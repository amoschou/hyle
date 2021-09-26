<?php

namespace AMoschou\Hyle\Components;

class TextField extends HyleComponent
{
    /**
     * The input control's value.
     *
     * @var string
     */
    public $value;

    /**
     * A string specifying the type of control to render.
     *
     * @var string 'text'|'search'|'tel'|'url'|'email'|'password'|'date'|'month'|'week'|'time'|'datetime-local'|'number'|'color'
     */
    public $type;

    /**
     * Sets floating label value.
     *
     * @var string
     */
    public $label;

    /**
     * Sets disappearing input placeholder.
     *
     * @var string
     */
    public $placeholder;

    /**
     * Prefix text to display before the input.
     *
     * @var string
     */
    public $prefix;

    /**
     * Suffix text to display after the input.
     *
     * @var string
     */
    public $suffix;

    /**
     * Leading icon to display in input.
     *
     * @var string
     */
    public $icon;

    /**
     * Trailing icon to display in input.
     *
     * @var string
     */
    public $iconTrailing;

    /**
     * Whether or not the input should be disabled.
     *
     * @var boolean
     */
    public $disabled;

    /**
     * Note: requries maxLength to be set. Display character counter with max length.
     *
     * @var boolean
     */
    public $charCounter;

    /**
     * Whether or not to show the material outlined variant.
     *
     * @var boolean
     */
    public $outlined;

    /**
     * Helper text to display below the input. Display default only when
     * focused.
     *
     * @var string
     */
    public $helper;

    /**
     * Always show the helper text despite focus.
     *
     * @var boolean
     */
    public $helperPersistent;

    /**
     * Displays error state if value is empty and input is blurred.
     *
     * @var boolean
     */
    public $required;

    /**
     * Maximum length to accept input.
     *
     * @var number
     */
    public $maxLength;

    /**
     * Minimum length to accept input.
     *
     * @var number
     */
    public $minLength;

    /**
     * Message to show in the error color when the textfield is invalid.
     * (Helper text will not be visible)
     *
     * @var string
     */
    public $validationMessage;

    /**
     * HTMLInputElement.prototype.pattern (empty string will unset attribute)
     *
     * @var string
     */
    public $pattern;

    /**
     * HTMLInputElement.prototype.min (empty string will unset attribute)
     *
     * @var number|string
     */
    public $min;

    /**
     * HTMLInputElement.prototype.max (empty string will unset attribute)
     *
     * @var number|string
     */
    public $max;

    /**
     * HTMLInputElement.prototype.size (null will unset attribute)
     *
     * @var number|null
     */
    public $size;

    /**
     * HTMLInputElement.prototype.step (null will unset attribute)
     *
     * @var number|null
     */
    public $step;

    /**
     * Reports validity on value change rather than only on blur.
     *
     * @var boolean
     */
    public $autoValidate;

    /**
     * The ValidityState of the textfield.
     *
     * @var validityState
     */
    public $validity;

    /**
     * HTMLInputElement.prototype.willValidate
     *
     * @var boolean
     */
    public $willValidate;

    /**
     * Callback called before each validation check. See the validation section for more details.
     *
     * @var validityTransform|null
     */
    public $validityTransform;

    /**
     * Runs validation check on initial render.
     *
     * @var boolean
     */
    public $validateOnInitialRender;

    /**
     * Sets the name attribute on the internal input.***
     *
     * @var string
     */
    public $name;

    /**
     * end-aligned
     *
     * @var boolean
     */
    public $endAligned;

    /**
     * text-area
     *
     * @var boolean
     */
    public $textArea;

    public $autocapitalize;

    public $readOnly;

    public $focused;

    protected $isUiValid;

    public $initialFocus;

    /**
     * Create a new component instance.
     *
     * @param  string  $id
     * @param  __  $__
     * @return void
     */
    public function __construct(
        $id = null,
        $value = '',
        $type = 'text',
        $label = null,
        $placeholder = '',
        $prefix = null,
        $suffix = null,
        $icon = null,
        $iconTrailing = null,
        $disabled = false,
        $charCounter = null,
        $outlined = null,
        $helper = null,
        $helperPersistent = null,
        $required = false,
        $minLength = -1,
        $maxLength = -1,
        $validationMessage = null, // previously '', but isset('') returns true
        $pattern = '',
        $min = '',
        $max = '',
        $size = null,
        $step = null,
        $autoValidate = null,
        $validity = null,
        $willValidate = null,
        $validityTransform = null,
        $validateOnInitialRender = null,
        $name = '',
        $endAligned = false,
        $textArea = false,
        $autocapitalize = '',
        $readOnly = false,
        $focused = false,
        $isUiValid = true,
        $initialFocus = false
    ) {
        parent::__construct($id);
        $this->value = $value;
        $this->type = $type;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->prefix = $prefix;
        $this->suffix = $suffix;
        $this->icon = $icon;
        $this->iconTrailing = $iconTrailing;
        $this->disabled = $disabled;
        $this->charCounter = $charCounter;
        $this->outlined = $outlined;
        $this->helper = $helper;
        $this->helperPersistent = $helperPersistent;
        $this->required = $required;
        $this->maxLength = $maxLength;
        $this->validationMessage = $validationMessage;
        $this->pattern = $pattern;
        $this->min = $min;
        $this->max = $max;
        $this->size = $size;
        $this->step = $step;
        $this->autoValidate = $autoValidate;
        $this->validity = $validity;
        $this->willValidate = $willValidate;
        $this->validityTransform = $validityTransform;
        $this->validateOnInitialRender = $validateOnInitialRender;
        $this->name = $name;
        $this->endAligned = $endAligned;
        $this->textArea = $textArea;
        $this->readOnly = $readOnly;
        $this->focused = $focused;
        $this->isUiValid = $isUiValid;
        $this->initialFocus = $initialFocus;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $shouldRenderCharCounter = $this->charCounter && $this->maxLength !== -1;

        $shouldRenderHelperText = isset($this->helper) || isset($this->validationMessage) || $shouldRenderCharCounter;

        // $this->label = $this->textArea ? false : $this->label;

        $class = 'mdc-text-field';
        $class .= $this->disabled ? ' mdc-text-field--disabled' : '';
        $class .= !$this->label ? ' mdc-text-field--no-label' : '';
        $class .= $this->outlined ? ' mdc-text-field--outlined' : ' mdc-text-field--filled';
        $class .= $this->icon ? ' mdc-text-field--with-leading-icon' : '';
        $class .= $this->iconTrailing ? ' mdc-text-field--with-trailing-icon' : '';
        $class .= $this->endAligned ? ' mdc-text-field--end-aligned' : '';
        // also (not inspired from mwc):
        // $class .= $this->focused ? ' mdc-text-field--focused mdc-text-field--label-floating' : '';

        $prefilled = (boolean) $this->value;

        $invalid = (boolean) $this->validationMessage;

        return view('hyle::text-field', [
            'shouldRenderCharCounter' => $shouldRenderCharCounter,
            'shouldRenderHelperText' => $shouldRenderHelperText,
            'prefilled' => $prefilled,
            'invalid' => $invalid,
            'class' => $class
        ]);
    }

    /**
     * Get the view / contents that represent the subcomponent.
     *
     * @return \Illuminate\View\View|string
     */
    public function renderInput($shouldRenderHelperText)
    {
        $showValidationMessage = $this->validationMessage && !$this->isUiValid;

        $inputAttributes = [
            'aria-labelledby' => "text-field::{$this->id}::floating-label",
            'aria-controls' => $shouldRenderHelperText ? "text-field::{$this->id}::helper-text" : null,
            'aria-describedby' => ($this->focused || $this->helperPersistent || $showValidationMessage) ? "text-field::{$this->id}::helper-text" : null,
            'aria-errortext' => $showValidationMessage ? "text-field::{$this->id}::helper-text" : null,
            'class' => 'mdc-text-field__input',
            'type' => $this->type,
            'value' => $this->value ? $this->value : null,
            'disabled' => $this->disabled ? true : null,
            'placeholder' => $this->placeholder === '' ? null : $this->placeholder,
            'required' => $this->required ? true : null,
            'readonly' => $this->readOnly ? true : null,
            'minLength' => $this->minLength === -1 ? null : $this->minLength,
            'maxLength' => $this->maxLength === -1 ? null : $this->maxLength,
            'pattern' => $this->pattern === '' ? null : $this->pattern,
            'min' => $this->min === '' ? null : $this->min,
            'max' => $this->max === '' ? null : $this->max,
            'step' => $this->step,
            'size' => $this->size,
            'name' => $this->name === '' ? null : $this->name,
            'inputmode' => $this->inputMode ?? null,
            'autocapitalize' => $this->autocapitalize === '' ? null : $this->autocapitalize,
            // also (not inspried from mwc)
            // 'autofocus' => $this->focused
            'data-mdc-dialog-initial-focus' => $this->initialFocus ? true : null
        ];

        $inputAttributesStrings = [];

        foreach($inputAttributes as $key => $val) {
            if(!is_null($val)) {
                if($val === true) {
                    $inputAttributesStrings[] = $key;
                } else {
                    $inputAttributesStrings[] = "{$key}=\"{$val}\"";
                }
            }
        }

        return '<input ' . implode(' ', $inputAttributesStrings) . '>';
    }

    public function renderHelperText($shouldRenderHelperText, $shouldRenderCharCounter, $hasValidationError = false) {
        $showValidationMessage = $this->validationMessage && $hasValidationError;

        $classes = 'mdc-text-field-helper-text';
        $classes .= $this->helperPersistent ? ' mdc-text-field-helper-text--persistent' : '';
        $classes .= $showValidationMessage ? ' mdc-text-field-helper-text--validation-msg' : '';

        $ariaHiddenOrUndef = $this->focused || $this->helperPersistent || $showValidationMessage ? null : 'true';

        $helperText = $showValidationMessage ? $this->validationMessage : $this->helper;

        if(!$shouldRenderHelperText) {
            return '';
        }

        $returnString = '<div class="mdc-text-field-helper-line">';
        $returnString .= '<div id="text-field-helper-text::' . $this->id . '::root"';
        $returnString .= is_null($ariaHiddenOrUndef) ? '' : ' aria-hidden="' . $ariaHiddenOrUndef . '"';
        $returnString .= ' class="' . $classes . '" >';
        $returnString .= $helperText;
        $returnString .= '</div>';
        $returnString .= $this->renderCharCounter($shouldRenderCharCounter);
        $returnString .= '</div>';

        return $returnString;
    }

    protected function renderCharCounter($shouldRenderCharCounter) {
        $length = min(mb_strlen($this->value), $this->maxLength);

        if(!$shouldRenderCharCounter) {
            return '';
        }

        return '<span class="mdc-text-field-character-counter">' . $length . ' / ' . $this->maxLength . '</span>';
    }

}
