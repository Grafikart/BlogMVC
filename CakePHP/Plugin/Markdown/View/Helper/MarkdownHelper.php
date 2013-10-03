<?php
class MarkdownHelper extends AppHelper{

    public $parser = false;

    public function parse($content){
        if(!$this->parser){
            App::import('Markdown.Vendor', 'Markdown');
            $this->parser = new Michelf\MarkdownExtra();
        }
        $content = $this->parser->transform($content);
        $replace_array = array(
            '<h1>'       => '<h3>',
            '</h1>'      => '</h3>',
            '<code>'     => '',
            '</code>'    => '',
            '<pre>'      => '<pre class="php" name="code">',
            '<p>!!</p>'  => '<p><a class="btn" onclick="$(this).parent().slideUp().next(\'.hidden\').slideDown();">Voir la réponse</a></p><div class="hidden">',
            '<p>/!!</p>' => '</div>'
        );
        $search = $replace = array();
        foreach($replace_array as $k=>$v){
            $search[] = $k;
            $replace[] = $v;
        }
        $content = str_replace($search, $replace, $content);
        return $content;
    }

}