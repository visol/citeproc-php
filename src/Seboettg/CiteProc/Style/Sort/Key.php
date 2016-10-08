<?php

namespace Seboettg\CiteProc\Style\Sort;
use Seboettg\CiteProc\CiteProc;
use Seboettg\CiteProc\Util\Variables;


/**
 * Class Key
 * The cs:sort element must contain one or more cs:key child elements. The sort key, set as an attribute on cs:key, must
 * be a variable (see Appendix IV - Variables) or macro name. For each cs:key element, the sort direction can be set to
 * either “ascending” (default) or “descending” with the sort attribute. The attributes names-min, names-use-first, and
 * names-use-last may be used to override the values of the corresponding et-al-min/et-al-subsequent-min,
 * et-al-use-first/et-al-subsequent-use-first and et-al-use-last attributes, and affect all names generated via macros
 * called by cs:key.
 *
 * @package Seboettg\CiteProc\Style\Sort
 *
 * @author Sebastian Böttger <boettger@hebis.uni-frankfurt.de>
 */
class Key implements SortKey
{
    /**
     * variable name or macro
     * @var string
     */
    private $variable;

    /**
     * sorting order
     * @var string
     */
    private $sort = "ascending";

    /**
     * macro name
     * @var string
     */
    private $macro;

    /**
     * Key constructor.
     * The cs:sort element must contain one or more cs:key child elements. The sort key, set as an attribute on cs:key,
     * must be a variable (see Appendix IV - Variables) or macro name. For each cs:key element, the sort direction can
     * be set to either “ascending” (default) or “descending” with the sort attribute.
     *
     * TODO: The attributes names-min, names-use-first, and names-use-last may be used to override the values of the
     * corresponding et-al-min/et-al-subsequent-min, et-al-use-first/et-al-subsequent-use-first and et-al-use-last
     * attributes, and affect all names generated via macros called by cs:key.
     *
     * @param \SimpleXMLElement $node
     */
    public function __construct(\SimpleXMLElement $node)
    {
        /** @var \SimpleXMLElement $attribute */
        foreach ($node->attributes() as $attribute) {
            $name = $attribute->getName();
            if ($name === "variable") {
                $this->variable = (string)$attribute;
            }
            if ($name === "sort") {
                $this->sort = (string) $attribute;
            }
            if ($name === "macro") {
                $this->variable = "macro";
                $this->macro = (string) $attribute;
            }
        }
    }

    /**
     * @return string
     */
    public function getVariable()
    {
        return $this->variable;
    }

    /**
     * @return string (ascending|descending)
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @return bool
     */
    public function isNameVariable()
    {
        return Variables::isNameVariable($this->variable);
    }

    /**
     * @return bool
     */
    public function isNumberVariable()
    {
        return Variables::isNumberVariable($this->variable);
    }

    /**
     * @return bool
     */
    public function isDateVariable()
    {
        return Variables::isDateVariable($this->variable);
    }

    /**
     * @return bool
     */
    public function isMacro()
    {
        return $this->variable === "macro" && !empty(CiteProc::getContext()->getMacro($this->macro));
    }
}