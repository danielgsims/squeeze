<?php

namespace Squeeze1_0\Implementable
{
  interface iApi
  {
    public function get($key);
    public function set($key, $val);
    public function save();
    public function delete();
    public function trash();
  }
}