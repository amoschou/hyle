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

    /**
     * Create a new component instance.
     *
     * @param  string  $id
     * @param  __  $__
     * @return void
     */
    public function __construct(
        $id = null,
        $value = null,
        $type = null,
        $label = null,
        $placeholder = null,
        $prefix = null,
        $suffix = null,
        $icon = null,
        $iconTrailing = null,
        $disabled = false,
        $charCounter = null,
        $outlined = null,
        $helper = null,
        $helperPersistent = null,
        $required = null,
        $maxLength = null,
        $validationMessage = null,
        $pattern = null,
        $min = null,
        $max = null,
        $size = null,
        $step = null,
        $autoValidate = null,
        $validity = null,
        $willValidate = null,
        $validityTransform = null,
        $validateOnInitialRender = null,
        $name = null,
        $endAligned = false,
        $textArea = false
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
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $this->label = $this->textArea ? false : $this->label;

        $class = 'mdc-text-field';
        $class .= $this->disabled ? ' mdc-text-field--disabled' : '';
        $class .= !$this->label ? ' mdc-text-field--no-label' : '';
        $class .= $this->outlined ? ' mdc-text-field--outlined' : ' mdc-text-field--filled';
        $class .= $this->icon ? ' mdc-text-field--with-leading-icon' : '';
        $class .= $this->iconTrailing ? ' mdc-text-field--with-trailing-icon' : '';
        $class .= $this->endAligned ? ' mdc-text-field--end-aligned' : '';

        $shouldRenderCharCounter = $this->charCounter && $this->maxLength !== -1;

        $shouldRenderHelperText = !!$this->helper || !!$this->validationMessage || $shouldRenderCharCounter;

        return view('hyle::text-field', [
            'shouldRenderCharCounter' => $shouldRenderCharCounter,
            'shouldRenderHelperText' => $shouldRenderHelperText,
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

        $str = [];

        $str[] = 'aria-labelledby="text-field::' . $this->id . '::floating-label"';

        if($shouldRenderHelperText) {
            $str[] = 'aria-controls="text-field::' . $this->id . '::helper-text"';
        }

        if($this->focused || $this->helperPersistent || $showValidationMessage) {
            $str[] = 'aria-describedby="text-field::' . $this->id . '::helper-text"';
        }

        if($showValidationMessage) {
            $str[] = 'aria-errortext="text-field::' . $this->id . '::helper-text"';
        }

        return '<input ' . implode(' ', $str) . '>';

        //// <input
        //// aria-labelledby="label"
        //// aria-controls="${ifDefined(ariaControlsOrUndef)}"
        // aria-describedby="${ifDefined(ariaDescribedbyOrUndef)}"
        // aria-errortext="${ifDefined(ariaErrortextOrUndef)}"
        // class="mdc-text-field__input"
        // type="${this.type}"
        // .value="${live(this.value) as unknown as string}"
        // ?disabled="${this.disabled}"
        // placeholder="${this.placeholder}"
        // ?required="${this.required}"
        // ?readonly="${this.readOnly}"
        // minlength="${ifDefined(minOrUndef)}"
        // maxlength="${ifDefined(maxOrUndef)}"
        // pattern="${ifDefined(this.pattern ? this.pattern : undefined)}"
        // min="${ifDefined(this.min === '' ? undefined : this.min as number)}"
        // max="${ifDefined(this.max === '' ? undefined : this.max as number)}"
        // step="${ifDefined(this.step === null ? undefined : this.step)}"
        // size="${ifDefined(this.size === null ? undefined : this.size)}"
        // name="${ifDefined(this.name === '' ? undefined : this.name)}"
        // inputmode="${ifDefined(this.inputMode)}"
        // autocapitalize="${ifDefined(autocapitalizeOrUndef)}"
        // @input="${this.handleInputChange}"
        // @focus="${this.onInputFocus}"
        // @blur="${this.onInputBlur}">`;
    }
}
