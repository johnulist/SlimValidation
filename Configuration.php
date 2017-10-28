<?php

/*
 * This file is part of the awurth/slim-validation package.
 *
 * (c) Alexis Wurth <alexis.wurth57@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Awurth\SlimValidation;

use InvalidArgumentException;
use Respect\Validation\Rules\AllOf;

/**
 * Configuration.
 *
 * @author Alexis Wurth <awurth.dev@gmail.com>
 */
class Configuration
{
    /**
     * @var mixed
     */
    protected $default;

    /**
     * @var string
     */
    protected $group;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string[]
     */
    protected $messages = [];

    /**
     * @var AllOf
     */
    protected $rules;

    /**
     * Constructor.
     *
     * @param AllOf|array $options
     * @param string      $key
     * @param string      $group
     * @param string      $default
     */
    public function __construct($options, $key = null, $group = null, $default = null)
    {
        $this->key = $key;
        $this->group = $group;
        $this->default = $default;

        if ($options instanceof AllOf) {
            $this->rules = $options;
        } else {
            $this->setOptions($options);
        }

        $this->validateOptions();
    }

    /**
     * Gets the default value for non-existent request parameters, object properties or array keys.
     *
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * Gets the group to use for errors and values storage.
     *
     * @return string
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Gets the key to use for errors and values storage.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Gets the error message.
     *
     * @return string|null
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Gets individual rules messages.
     *
     * @return string[]
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Gets the validation rules.
     *
     * @return AllOf
     */
    public function getValidationRules()
    {
        return $this->rules;
    }

    /**
     * Tells whether a group has been set.
     *
     * @return bool
     */
    public function hasGroup()
    {
        return !empty($this->group);
    }

    /**
     * Tells whether a key has been set.
     *
     * @return bool
     */
    public function hasKey()
    {
        return !empty($this->key);
    }

    /**
     * Tells whether a single message has been set.
     *
     * @return bool
     */
    public function hasMessage()
    {
        return !empty($this->message);
    }

    /**
     * Tells whether individual rules messages have been set.
     *
     * @return bool
     */
    public function hasMessages()
    {
        return !empty($this->messages);
    }

    /**
     * Sets the default value for non-existent request parameters, object properties or array keys.
     *
     * @param string $default
     */
    public function setDefault($default)
    {
        $this->default = $default;
    }

    /**
     * Sets the group to use for errors and values storage.
     *
     * @param string $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

    /**
     * Sets the key to use for errors and values storage.
     *
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * Sets the error message.
     *
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Sets individual rules messages.
     *
     * @param string[] $messages
     */
    public function setMessages(array $messages)
    {
        $this->messages = $messages;
    }

    /**
     * Sets options from an array.
     *
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $availableOptions = [
            'default',
            'group',
            'key',
            'message',
            'messages',
            'rules'
        ];

        foreach ($availableOptions as $option) {
            if (isset($options[$option])) {
                $this->$option = $options[$option];
            }
        }
    }

    /**
     * Sets the validation rules.
     *
     * @param AllOf $rules
     */
    public function setValidationRules(AllOf $rules)
    {
        $this->rules = $rules;
    }

    /**
     * Verifies that all mandatory options are set and valid.
     */
    public function validateOptions()
    {
        if (!$this->rules instanceof AllOf) {
            throw new InvalidArgumentException('Validation rules are missing or invalid');
        }

        if (!$this->hasKey()) {
            throw new InvalidArgumentException('A key must be set');
        }

        if ($this->hasMessage() && !is_string($this->message)) {
            throw new InvalidArgumentException(sprintf('Expected custom message to be of type string, %s given', gettype($this->message)));
        }
    }
}
