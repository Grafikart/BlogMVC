<?php

/**
 * This formatter allows dumping models in different formats (currently just
 * JSON and XML).
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class ModelFormatter extends \CComponent
{
    /**
     * Empty initializer for compliance.
     *
     * @return void
     * @since 0.1.0
     */
    public function init()
    {
    }

    /**
     * Formats model or array of models into specified format.
     *
     * @param \CModel|\CModel[] $subject Model or array of models to be dumped.
     * @param string            $format  Format models should be dumped to.
     *
     * @return string
     * @since 0.1.0
     */
    public function format($subject, $format='json')
    {
        if ($format === 'json') {
            return $this->jsonify($subject);
        } else if ($format === 'xml') {
            return $this->xmlify($subject);
        } else {
            $message = 'Unknown format supported ('.$format.')';
            throw new \BadMethodCallException($message);
        }
    }

    /**
     * Formats model or array of models into JSON.
     *
     * @param \CModel|\CModel[] $subject Model or array of models to format.
     *
     * @return string JSON string.
     * @since 0.1.0
     */
    public function jsonify($subject)
    {
        if ($subject instanceof \CModel) {
            return $this->jsonifyModel($subject);
        } else if (is_array($subject)) {
            return $this->jsonifyModels($subject);
        } else {
            throw new \BadMethodCallException('Invalid argument');
        }
    }

    /**
     * Returns XML representation of single model or array of models.
     *
     * @param \CModel|\CModel[] $subject Model or array of models to be turned
     * into XML document.
     *
     * @return string
     * @since 0.1.0
     */
    public function xmlify($subject)
    {
        if ($subject instanceof \CModel) {
            return $this->xmlifyModel($subject);
        } else if (is_array($subject)) {
            return $this->xmlifyModels($subject);
        } else {
            throw new \BadMethodCallException('Invalid argument');
        }
    }

    /**
     * Creates JSON representation of provided model.
     *
     * @param \CModel $model Model to be represented.
     *
     * @return string JSON representation.
     * @since 0.1.0
     */
    public function jsonifyModel(\CModel $model)
    {
        return \CJSON::encode($this->getModelPublicAttributes($model));
    }

    /**
     * Creates JSON representation of provided models
     *
     * @param \CModel[] $models List of models to be JSON'ified.
     *
     * @return string JSON representation of provided models.
     * @since 0.1.0
     */
    public function jsonifyModels($models)
    {
        $data = array();
        foreach ($models as $model) {
            $data[] = $this->getModelPublicAttributes($model);
        }
        return \CJSON::encode($data);
    }

    /**
     * Formats single model as XML document.
     *
     * @param \CModel $model Model to be formatted.
     *
     * @return string XML document.
     * @since 0.1.0
     */
    public function xmlifyModel(\CModel $model)
    {
        $xml = new SimpleXMLElement('<xml/>');
        $attributes = $this->getModelPublicAttributes($model);
        foreach ($attributes as $key => $value) {
            $xml->addChild($key, $value);
        }
        return $xml->asXML();
    }

    /**
     * Rpresents array of models as an XML document.
     *
     * @param \CModel[] $models Array of models to be inserted in XML document.
     *
     * @return string XML document.
     * @since 0.1.0
     */
    public function xmlifyModels($models)
    {
        $xml = new SimpleXMLElement('<xml/>');
        foreach ($models as $model) {
            $modelElement = $xml->addChild(get_class($model));
            $attributes = $this->getModelPublicAttributes($model);
            foreach ($attributes as $key => $value) {
                $modelElement->$key = $value;
            }
        }
        return $xml->asXML();
    }

    /**
     * Returns array of model's public attributes.
     *
     * @param \CModel $model Model to be inspected.
     *
     * @return array Array of model's public attributes.
     * @since 0.1.0
     */
    protected function getModelPublicAttributes(\CModel $model)
    {
        if (method_exists($model, 'getPublicAttributes')) {
            return $model->getPublicAttributes();
        }
        return $model->getAttributes();
    }
}
 