<?php

class NumberingTest extends PanelTestCase {

  public function __construct() {

    parent::__construct();

    $this->removeContent();
    $this->removeAccounts();

    $this->user = $this->createAdmin();
    $this->user->login('test');

  }

  protected function setUp() {
    $this->removeContent();
  }

  public function testSortArticles() {

    $blog = $this->site->children()->create('blog', 'blog');

    $a = $blog->children()->create('article-a', 'article', array(
      'title' => 'Article A',
      'date'  => '2012-12-12 22:33:00'
    ));

    $b = $blog->children()->create('article-b', 'article', array(
      'title' => 'Article B',
      'date'  => '2013-12-12 22:33:00'
    ));

    $c = $blog->children()->create('article-c', 'article', array(
      'title' => 'Article C',
      'date'  => '2014-12-12 22:33:00'
    ));

    $a->sort();
    $b->sort();
    $c->sort();

    $this->assertEquals(20121212, $a->num());
    $this->assertEquals(20131212, $b->num());
    $this->assertEquals(20141212, $c->num());

  }

  public function testSortAlphabetic() {

    $alphabet = $this->site->children()->create('alphabet', 'alphabet');

    $a = $alphabet->children()->create('a', 'char', array(
      'title' => 'A'
    ));

    $b = $alphabet->children()->create('b', 'char', array(
      'title' => 'B'
    ));

    $c = $alphabet->children()->create('c', 'char', array(
      'title' => 'C'
    ));

    $a->sort();
    $b->sort();
    $c->sort();

    $this->assertEquals(0, $a->num());
    $this->assertEquals(0, $b->num());
    $this->assertEquals(0, $c->num());

  }

}