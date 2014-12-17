<?php

namespace Wineot\FrontEnd\SearchBundle\Tests\Controller;
use Wineot\SearchBundle\Form\Type\SearchType;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Form\Test\TypeTestCase;

class SearchControllerTest extends TypeTestCase
{
    public function testSearch()
    {
        $formData = array('searchInput' => 'bonjour');

        $type = new SearchType();
        $form = $this->factory->create($type);

        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $view = $form->createView();
        $children = $view->children;
        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
