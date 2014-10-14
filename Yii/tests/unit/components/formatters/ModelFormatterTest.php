<?php
namespace components\formatters;


class ModelFormatterTest extends \Codeception\TestCase\Test
{
   /**
    * @var \CodeGuy
    */
    protected $guy;

    public function _before()
    {
        \Yii::app()->fixtureManager->prepare();
    }
    public function modelProvider()
    {
        return \User::model()->findAll();
    }
    // tests
    /**
     * Tests all XML formatting.
     *
     * @return void
     * @since 0.1.0
     */
    public function testXmlFormatting()
    {
        $formatter = new \ModelFormatter;
        $models = $this->modelProvider();
        $model = $models[0];
        if (method_exists($model, 'getPublicAttributes')) {
            $attrs = $model->getPublicAttributes();
        } else {
            $attrs = $model->getAttributes();
        }

        $xml = new \SimpleXMLElement($formatter->xmlifyModel($model));
        $this->assertEquals($attrs, (array) $xml->children());

        $xml = new \SimpleXMLElement($formatter->xmlifyModels($models));
        $children = (array) $xml->children();
        foreach ($children as $class => $data) {
            foreach ($data as $item) {
                $item = (array) $item;
                foreach (array_keys($attrs) as $key) {
                    $this->assertArrayHasKey($key, $item);
                }
            }
        }

        $this->assertEquals(
            $formatter->xmlify($model),
            $formatter->xmlifyModel($model)
        );
        $this->assertEquals(
            $formatter->xmlify($models),
            $formatter->xmlifyModels($models)
        );

        $this->assertEquals(
            $formatter->format($model, 'xml'),
            $formatter->xmlifyModel($model)
        );
        $this->assertEquals(
            $formatter->format($models, 'xml'),
            $formatter->xmlifyModels($models)
        );
    }

    /**
     * Tests all json formatting.
     *
     * @return void
     * @since 0.1.0
     */
    public function testJsonFormatting()
    {
        $formatter = new \ModelFormatter;
        $models = $this->modelProvider();
        $model = $models[0];
        if (method_exists($model, 'getPublicAttributes')) {
            $attrs = $model->getPublicAttributes();
        } else {
            $attrs = $model->getAttributes();
        }

        $reModel = \CJSON::decode($formatter->jsonifyModel($model));
        $this->assertEquals($attrs, $reModel);

        $reModels = \CJSON::decode($formatter->jsonifyModels($models));
        foreach ($reModels as $reModel) {
            foreach (array_keys($attrs) as $name) {
                $this->assertArrayHasKey($name, $reModel);
            }
        }

        $this->assertEquals(
            $formatter->jsonify($model),
            $formatter->jsonifyModel($model)
        );
        $this->assertEquals(
            $formatter->jsonify($models),
            $formatter->jsonifyModels($models)
        );
        $this->assertEquals(
            $formatter->format($model, 'json'),
            $formatter->jsonifyModel($model)
        );
        $this->assertEquals(
            $formatter->format($models, 'json'),
            $formatter->jsonifyModels($models)
        );
    }
}