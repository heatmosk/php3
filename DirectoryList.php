<?php

class DirectoryList
{
  private $path;
  private $folders;
  private $files;

  public function __construct($path)
  {
    $this->path = realpath($path);
    $this->folders = [];
    $this->files = [];
    $this->scanFolder($path);
  }
  private function scanFolder($path)
  {
    $iter = new DirectoryIterator($path);
    while ($iter->valid()) {
      if ($iter->current() != ".") {
        $item = [
          "text" => (string) $iter->current(),
          "class" => $iter->current()->isDir() ? "icon_folder" : "icon_file",
          "ext" => $iter->current()->getExtension()
        ];
        if ($iter->current()->isDir()) {
          $this->folders[] = $item;
        } else {
          $this->files[] = $item;
        }
      }
      $iter->next();
    }
    asort($this->folders);
    asort($this->files);
  }
  public function render(): string
  {
    return "<div class='listing'>"
      . "<div>Содержимое папки " . $this->path . "</div>"
      . "<ul class='directory__list'>"
      . $this->renderItems($this->folders, false)
      . $this->renderItems($this->files, true)
      . "</ul>"
      . "</div>";
  }
  private function renderItems(array $items, $createLink = true): string
  {
    $path = $this->path;
    return implode(array_map(function ($item) use ($path, $createLink) {
      $listItem = "<div class='directory__list__item " . $item["class"] . "'>" . $item["text"] . "</div>";
      if ($item["ext"] != "php") {
        if ($createLink) {
          $url = str_replace($_SERVER['DOCUMENT_ROOT'], "", $path . "/" . $item["text"]);
        } else {
          $url = './?path=' . realpath($path . "/" . $item["text"]);
        }
        $listItem = "<a href='" . $url . "'>" . $listItem . "</a>";
      }
      return "<li>" . $listItem . "</li>";
    }, $items));
  }
}
