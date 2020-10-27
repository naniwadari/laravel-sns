<?php

namespace App;

class Sort
{
  //keyの情報は事前にある前提で作成しています。
  public static function sort($collection)
  {
    $keys = ["C", "B", "A", "D"];
    $sorted = $collection->sort(function ($first, $second) use ($keys) {
      foreach ($keys as $key) {
        //値が違う場合は比較処理
        if (self::isDiffrent($first, $second, $key)) {
          $isDesc = self::decideOrder($key);
          return self::compareColumn($first, $second, $key, $isDesc);
        }
        //同じ場合はこのkeyの比較をスキップ
        continue;
      }
    });
    return $sorted;
  }

  //値が異なるか？
  public static function isDiffrent($first, $second, $key)
  {
    if ($first->$key === $second->$key) {
      return false;
    }
    return true;
  }

  //カラム内容の比較、orderによって返す値を変える
  public static function compareColumn($first, $second, $key, $isDesc)
  {
    if ($first->$key > $second->$key) {
      return $isDesc ? -1 : 1;
    }
    return $isDesc ? 1 : -1;
  }

  //key情報をみてASCかどうかを判断
  public static function decideOrder($key)
  {
    if ($key === "C") {
      return false;
    }
    return true;
  }

  //サンプルデータ作成用メソッド//
  public static function init()
  {
    $data = self::makeSampleData();
    return collect($data);
  }

  public static function makeRecord($values)
  {
    $keys = ["C", "B", "A", "D"];
    $record = [];
    foreach ($keys as $index => $key) {
      $record[$key] = $values[$index];
    }
    return $record;
  }

  public static function makeSampleData()
  {
    $valueArrays = [
      [5, 1, 2, 1],
      [4, 2, 3, 2],
      [4, 2, 3, 1],
      [5, 1, 2, 1],
      [4, 2, 2, 1],
      [6, 1, 1, 1],
      [6, 1, 1, 2],
    ];
    $data = [];
    foreach ($valueArrays as $values) {
      $data[] = new SomeData($values);
    }
    return $data;
  }
}

//サンプルデータクラス
class SomeData
{
  public function __construct($values)
  {
    $this->C = $values[0];
    $this->B = $values[1];
    $this->A = $values[2];
    $this->D = $values[3];
    return $this;
  }
}
