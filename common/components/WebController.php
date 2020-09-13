<?php

namespace rusbeldoor\yii2General\common\components;

/**
 * Контроллер
 */
class WebController extends \yii\web\Controller
{
    /**
     * Returns the route of the current request.
     * @return string the route (module ID, controller ID and action ID) of the current request.
     */
    public function getRoute()
    {
        return ((($this->action !== null) && ($this->action !== 'index')) ? $this->action->getUniqueId() : $this->getUniqueId());
    }
}
