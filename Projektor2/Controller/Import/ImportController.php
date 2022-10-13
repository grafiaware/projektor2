<?php


/**
 * Description of ImportConzroller
 *
 * @author pes2704
 */
class Projektor2_Controller_Import_ImportController {

    const UPLOADED_KEY = "filesuploaded";

    private $uploadedFolderPath;

    private $multiple=false;

    private $accept="";

    public function importTable(ServerRequestInterface $request) {
        /* @var $view View */
        $view = $this->container->get(View::class);

        if ($this->isPermittedMethod(__METHOD__)) {
            $form = $this->getSelectForm('act/upload/table');
            $view
                ->setTemplate(new PhpTemplate(PROJECT_PATH.'/templates/content/import.php'))
                ->setData(["form"=>$form]);
        } else{
            /* @var $view View */
            $layoutView = $this->container->get(View::class);
            $layoutView->setData("<div style='display:none'>action not permitted</div>");
        }
        $layoutView = $this->getLayoutView($request);
        $layoutView->appendComponentView($view, 'content');
        return $this->createResponse($request, $layoutView);
    }

    private function getSelectForm($formAction) {
        $name = self::UPLOADED_KEY."[]";
        $accept = $this->accept;
        $multiple = $this->multiple;

        $form = Html::tag('form', ["method"=>"POST", "action"=>$formAction, "enctype"=>"multipart/form-data"],
            Html::tag("input", ["type" => "file", "name" => $name, "accept" => $accept, "multiple" => $multiple])
            .Html::tag("input", ["type"=>"submit", "name"=>"UploadBtn", "value"=>"Upload"])
        );
        return $form;
    }

    private function uploadTable(ServerRequestInterface $request) {

        if ($this->isPermittedMethod(__METHOD__)) {
            // POST
            $uploads = $this->saveUploaded($request);
            if ($uploads) {
                $message[] = "Přijato a uloženo. Počet souborů ".count($uploads).".";
            } else {
                $message[] = "Nebyl přijat a uložen žádný soubor!";
            }
            #### konfigurace
            #
                $tables["Parovani.csv"] = new ImportTableConfig("parovani",
                        ["kompetence"=>"VARCHAR(500)", "kompetence_vyhledana"=>"VARCHAR(500)", "match_kompetence"=>"VARCHAR(500)",
                        "skoleni"=>"VARCHAR(500)", "kurz_vyhledany"=>"VARCHAR(500)", "match_kurz"=>"VARCHAR(500)"]);
                $tables["Osoby.csv"] = new ImportTableConfig("osoby",
                        ["osoby"=>"VARCHAR(1500)"]);
                $tables["Systemizace.csv"] = new ImportTableConfig("systemizace", [], "VARCHAR(200)", 3);
                $tables["Registrace osob - import - Kopie importu.csv"] = new ImportTableConfig("registrace_osob", [], "VARCHAR(500)", 2);

            #
            ####

            /** @var ImportTablesSql $tableService */
            $tableService = $this->container->get(ImportTablesSql::class);

            foreach ($uploads as $filePath) {
                $fileInfo = new FileInfo($filePath);  // exception
                $fileBasename = $fileInfo->getFileName().'.'.$fileInfo->getExtension();
                if (!array_key_exists($fileBasename, $tables)) {
                    throw new \UnexpectedValueException("Nenalezena konfigurace importu do table pro soubor '$filePath'.");
                }
                if ($tableService->insertIntoDatabase($fileInfo, $tables[$fileBasename])) {
                    $message[] = "Úspěšně vytvořena tabulka pro importovaný soubor '$filePath'";
                } else {
                    $message[] = "Selhalo vykonání sql příkazů pro import souboru '$filePath'";
                }
            }
            /** @var FlashStatusRepo $flashRepo */
            $flashRepo = $this->container->get(FlashStatusRepo::class);
            $flashRepo->add((new FlashStatus())->setFlash(implode(PHP_EOL, $message)));
            return RedirectResponse::withPostRedirectGet(new Response(), $request->getAttribute(AppFactory::URI_INFO_ATTRIBUTE_NAME)->getSubdomainPath()); // 303 See Other

        }
    }

    private function saveUploaded(ServerRequestInterface $request) {
            $files = $request->getUploadedFiles()[self::UPLOADED_KEY];
            $size = 0;
            if (!isset($this->uploadedFolderPath)) {
                throw new \LogicException("Není nastavena složka pro upload souborů. Nastavte voláním metody setUploadedFolderPath().");
            }
            $uploads=[];
            foreach ($files as $file) {
                /* @var $file UploadedFileInterface */
                $size += $file->getSize();
                $filePath = $this->uploadedFolderPath.$file->getClientFilename();
                $file->moveTo($filePath);
                $uploads[] = $filePath;
            }

            // $size - nevyužito

            return $uploads;
    }

    public function setUploadedFolderPath($uploadedFolderPath = self::UPLOADED_FOLDER) {
        $this->uploadedFolderPath = $uploadedFolderPath;
    }

    /**
     * Nastaví, zda bude možné vybrat k uploadu více souborů současně.
     *
     * @param bool $multiple
     */
    public function setMultiple($multiple=false) {
        $this->multiple = (bool) $multiple;
    }

    /**
     * Nastaví omezení přípon souborů, které bude možné uploadovat. Pokud není zadáno, dialog pro váběr souboru nebo souborů nabízí všechny typy souborů.
     *
     * @param array $acceptedExtensions Pole hodnot
     */
    public function setAcceptedExtensions(array $acceptedExtensions=[]) {
        $accepted = [];
        foreach ($acceptedExtensions as $extension) {
            $accepted[] =".".trim(trim($extension), ".");
        }
        $this->accept = implode(", ", $accepted);
    }

}
