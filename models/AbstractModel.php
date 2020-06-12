<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

class AbstractModel extends ActiveRecord {

    protected static function newDefaultGetterClosure($getter)
    {
        return function($m) use ($getter){
            $d = $m->$getter();
            return $d instanceof AbstractModel ? $d->asArray() : $d;
        };
    }

    protected function getGettersArrayMap(): array
    {
        $map = [];
        $attributes = $this->attributes();

        foreach ($attributes as $a){
            $getter = 'get' . Inflector::camelize($a);
            if($this->hasMethod($getter)){
                $map[$a] = self::newDefaultGetterClosure($getter);
            }
            else {
                $map[] = $a;
            }
        }

        return $map;
    }

    public function asArray(): array
    {
        $map = $this->getGettersArrayMap();
        return ArrayHelper::toArray($this, [self::className() => $map], true);
    }

    /**
     * Busca por todos itens
     * @return array
     */
    public static function fetchAll()
    {
        return Self::find()->all();
    }

    public static function findOneById($id)
    {
        return Self::find()->where(['id' => $id])->one();
    }
}
