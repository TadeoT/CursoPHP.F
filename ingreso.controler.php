<?php

class Ingreso_Controller
{
    public function main()
    {
        $tpl= new TemplatePower("./templates/menu.html");
        $tpl->prepare();
        $tpl-> gotoBlock("_ROOT");

        return $tpl->getOutputContent();
    }
}
