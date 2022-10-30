<?php
namespace Gogo\Viewmodel;

use Gogo\Hydrator\HydratorInterface;

/**
 * Description of ViewmodelAbstract
 *
 * @author pes2704
 */
abstract class ViewmodelAbstract implements ViewmodelInterface {

    /**
     *
     * @var HydratorInterface
     */
    protected $viewHydrator;

    public function __construct(HydratorInterface $viewHydrator) {
        $this->viewHydrator = $viewHydrator;
    }
}
