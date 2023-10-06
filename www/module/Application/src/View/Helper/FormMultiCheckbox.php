<?php

declare(strict_types=1);

namespace Application\View\Helper;

use Laminas\Form\Element\MultiCheckbox as MultiCheckboxElement;
use Laminas\Form\LabelAwareInterface;

class FormMultiCheckbox extends \Laminas\Form\View\Helper\FormMultiCheckbox
{
    public const INPUT_WRAPPER_CLASS = 'input_wrapper_class';
    public const OPTIONS_WRAPPER_CLASS = 'options_wrapper_class';
    public const OPTION_WRAPPER_CLASS = 'option_wrapper_class';

    /**
     * @inheritDoc
     */
    protected function renderOptions(
        MultiCheckboxElement $element,
        array $options,
        array $selectedOptions,
        array $attributes,
    ): string {
        $escapeHtmlHelper = $this->getEscapeHtmlHelper();
        $labelHelper = $this->getLabelHelper();
        $labelClose = $labelHelper->closeTag();
        $labelPosition = $this->getLabelPosition();
        $closingBracket = $this->getInlineClosingBracket();

        $globalLabelAttributes = $element->getLabelAttributes();
        if (empty($globalLabelAttributes)) {
            $globalLabelAttributes = $this->labelAttributes;
        }

        $combinedMarkup = [];
        $count = 0;

        foreach ($options as $key => $optionSpec) {
            $count++;
            if ($count > 1 && array_key_exists('id', $attributes)) {
                unset($attributes['id']);
            }

            $value = '';
            $label = '';
            $inputAttributes = $attributes;
            $labelAttributes = $globalLabelAttributes;
            $selected = isset($inputAttributes['selected'])
                && $inputAttributes['type'] !== 'radio'
                && $inputAttributes['selected'];
            $disabled = isset($inputAttributes['disabled']) && $inputAttributes['disabled'];

            if (is_scalar($optionSpec)) {
                $optionSpec = [
                    'label' => $optionSpec,
                    'value' => $key,
                ];
            }

            if (isset($optionSpec['value'])) {
                $value = $optionSpec['value'];
            }
            if (isset($optionSpec['label'])) {
                $label = $optionSpec['label'];
            }
            if (isset($optionSpec['selected'])) {
                $selected = $optionSpec['selected'];
            }
            if (isset($optionSpec['disabled'])) {
                $disabled = $optionSpec['disabled'];
            }
            if (isset($optionSpec['label_attributes'])) {
                $labelAttributes = isset($labelAttributes)
                    ? array_merge($labelAttributes, $optionSpec['label_attributes'])
                    : $optionSpec['label_attributes'];
            }
            if (isset($optionSpec['attributes'])) {
                $inputAttributes = array_merge($inputAttributes, $optionSpec['attributes']);
            }

            if (in_array($value, $selectedOptions)) {
                $selected = true;
            }

            $inputAttributes['value'] = $value;
            $inputAttributes['checked'] = $selected;
            $inputAttributes['disabled'] = $disabled;

            $input = sprintf(
                '<input %s%s',
                $this->createAttributesString($inputAttributes),
                $closingBracket
            );

            if (null !== ($translator = $this->getTranslator())) {
                $label = $translator->translate(
                    $label,
                    $this->getTranslatorTextDomain()
                );
            }

            if (!$element instanceof LabelAwareInterface || !$element->getLabelOption('disable_html_escape')) {
                $label = $escapeHtmlHelper($label);
            }

            $labelOpen = $labelHelper->openTag($labelAttributes);

            $inputWrapperClass = $element->getOption(self::INPUT_WRAPPER_CLASS);
            if ($inputWrapperClass) {
                $template = '<div class="%s">%s%s%s%s</div>';
                $markup = match ($labelPosition) {
                    self::LABEL_PREPEND => sprintf($template, $inputWrapperClass, $labelOpen, $label, $labelClose, $input),
                    default             => sprintf($template, $inputWrapperClass, $input, $labelOpen, $label, $labelClose),
                };
            }
            else {
                $template = $labelOpen . '%s%s' . $labelClose;
                $markup = match ($labelPosition) {
                    self::LABEL_PREPEND => sprintf($template, $label, $input),
                    default             => sprintf($template, $input, $label),
                };
            }

            $optionWrapperClass = $element->getOption(self::OPTION_WRAPPER_CLASS);
            if ($optionWrapperClass) {
                $markup = sprintf('<div class="%s">%s</div>', $optionWrapperClass, $markup);
            }

            $combinedMarkup[] = $markup;
        }

        $markup = implode($this->getSeparator(), $combinedMarkup);

        $fieldsetWrapperClass = $element->getOption(self::OPTIONS_WRAPPER_CLASS);
        if ($fieldsetWrapperClass) {
            $markup = sprintf('<div class="%s">' .
                '<style>.list-notification { display: none; } .list-notification:last-child { display: block; }</style>' .
                '<div class="list-notification">The list is empty.</div>' .
                '%s</div>', $fieldsetWrapperClass, $markup);
        }

        return $markup;
    }
}
