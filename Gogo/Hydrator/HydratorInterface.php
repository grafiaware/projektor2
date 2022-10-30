<?php
namespace Gogo\Hydrator;

/**
 *
 * @author pes2704
 */
interface HydratorInterface {
    public function hydrate(&$model, &$data);
    public function extract(&$model, &$data);
}
