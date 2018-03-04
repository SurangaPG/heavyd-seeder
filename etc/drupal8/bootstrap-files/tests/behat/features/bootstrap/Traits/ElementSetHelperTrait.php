<?php

namespace DrupalProject\Behat\Traits;

use Behat\Gherkin\Node\TableNode;
use DrupalProject\Behat\Helpers\ElementSetHelper;

/**
 * Class ElementSetHelper
 *
 * Contains helpers to check or all the items contains the exact amount of
 * pieces of text.
 */
trait ElementSetHelperTrait {

  /**
   * Spoof underlying mink items.
   */
  use AbstractBaseTrait;

  /**
   * @param string $selector
   *   The selector to use.
   * @param \Behat\Gherkin\Node\TableNode $expectedData
   *   Table node with singular text data to use.
   * @param string $selectorType
   *   Selector type, defaults to css.
   * @return \DrupalProject\Behat\Helpers\ElementSetHelper
   */
  public function createSetHelperFromSelectorAndTableNode(string $selector, TableNode $expectedData, $selectorType = 'css') {
    $extractedExpectations = [];
    foreach ($expectedData->getRows() as $row) {
      $extractedExpectations[] = reset($row);
    }
    $extractedExpectations = array_filter($extractedExpectations);

    $elements = $this->getSession()->getPage()->findAll($selectorType, $selector);
    $elements = isset($elements) ? $elements : [];

    return new ElementSetHelper($elements, $extractedExpectations);
  }

  /**
   * Check a set of elements and validate that all the strings are in the set.
   *
   * @param array $elements
   *   The elements where the text resides in.
   * @param array $strings
   *   All the strings to find.
   */
  public function validateOnlyStringsInElementSet(array $elements, array $strings) {

  }
}

