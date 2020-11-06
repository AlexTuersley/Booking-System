<?php
Class WebPage{
    private $header;
    private $title;
    private $css;
    private $main;
    private $footer;

    public function __construct($pageTitle, $pageHeading1, $navList, $footerText) {
        $this->main = "";
        $this->set_css();
        $this->set_pageStart($pageTitle,$this->css);
        $this->set_header($pageHeading1,$navList);
        $this->set_footer($footerText);
        $this->set_pageEnd();
    }

    private function set_pageStart($pageTitle,$css) {
        $this->pageStart = <<<PAGESTART
        <!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="utf-8" />
        <title>$pageTitle</title>
        <link rel="stylesheet" href="$css">
        </head>
        <body>
        PAGESTART;
    }

    /**
    * Sets the path to the css on the page
    */
    private function set_css() {
        $this->css = CSS; 
    }

     /**
    * function sets up the main content of the page
    * @param $main - the content of the page that will be displayed
    */
    private function set_main($main) {
        $this->main = <<<MAIN
        <main>
        $main
        </main>
        MAIN;
    }
    /**
     * functions sets the footer of the page
     * @param $footerText - the text that will appear in the footer of the page
    */
    private function set_footer($footerText) {
        $this->footer = <<<FOOTER
        <footer>
        $footerText
        </footer>
        </body>
        </html>
        FOOTER;
    }

    /**
    * function adds content to the body of the page
    * @param $text - text that will be added to the main content of the page
    */
    public function addToBody($text) {
        $this->main .= $text;
    }
 
    /**
     * gets all the content from the other functions
     * @return HTML web page with all the content
     */
    public function get_page() {
        $this->set_main($this->main);
        return 
        $this->pageStart.
        $this->header.
        $this->main.
        $this->footer;
    }

}
?>