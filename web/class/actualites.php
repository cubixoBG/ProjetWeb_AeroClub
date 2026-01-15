<?php 

class Actualite {
    private int $id;
    private string $title;
    private string $text;
    private string $image;
    private DateTime $date;

    public function __construct(string $title, string $text, string $image) {
        $this->title = $title;
        $this->text = $text;
        $this->image = $image;
        $this->date = new DateTime();
    }
}

?>