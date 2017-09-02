<?php

namespace Viviniko\Support;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

trait ValidatesData
{
    /**
     * The default error bag.
     *
     * @var string
     */
    protected $validatesRequestErrorBag;

    /**
     * Run the validation routine against the given validator.
     *
     * @param  \Illuminate\Contracts\Validation\Validator|array  $validator
     * @param  array  $data
     * @return void
     */
    public function validateWith($validator, array $data)
    {
        if (is_array($validator)) {
            $validator = $this->getValidationFactory()->make($data, $validator);
        }

        if ($validator->fails()) {
            $this->throwValidationException($data, $validator);
        }
    }

    /**
     * Validate the given data with the given rules.
     *
     * @param  array  $data
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return void
     */
    public function validate(array $data, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = $this->getValidationFactory()->make($data, $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $this->throwValidationException($data, $validator);
        }
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param  string  $errorBag
     * @param  array  $data
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateWithBag($errorBag, array $data, array $rules, array $messages = [], array $customAttributes = [])
    {
        $this->withErrorBag($errorBag, function () use ($data, $rules, $messages, $customAttributes) {
            $this->validate($data, $rules, $messages, $customAttributes);
        });
    }

    /**
     * Execute a Closure within with a given error bag set as the default bag.
     *
     * @param  string  $errorBag
     * @param  callable  $callback
     * @return void
     */
    protected function withErrorBag($errorBag, callable $callback)
    {
        $this->validatesRequestErrorBag = $errorBag;

        call_user_func($callback);

        $this->validatesRequestErrorBag = null;
    }

    /**
     * Throw the failed validation exception.
     *
     * @param  array  $data
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function throwValidationException(array $data, $validator)
    {
        throw new ValidationException($validator);
    }

    /**
     * Format the validation errors to be returned.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return array
     */
    protected function formatValidationErrors(Validator $validator)
    {
        return $validator->errors()->getMessages();
    }

    /**
     * Get the key to be used for the view error bag.
     *
     * @return string
     */
    protected function errorBag()
    {
        return $this->validatesRequestErrorBag ?: 'default';
    }

    /**
     * Get a validation factory instance.
     *
     * @return \Illuminate\Contracts\Validation\Factory
     */
    protected function getValidationFactory()
    {
        return app(Factory::class);
    }
}
