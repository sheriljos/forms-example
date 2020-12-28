<?php


namespace lib;


interface TemplateInterface
{
    /**
     * @param string $templatePath
     * @param array $templateVariables
     * @return string
     */
    public function render(string $templatePath, array $templateVariables=[]): string;
}
