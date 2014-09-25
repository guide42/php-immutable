<?php

interface Sequence extends ArrayAccess, Countable, IteratorAggregate,
                           Container {
    /**
     * Return $x's index or throw an exception.
     *
     * @param unknown $x
     *
     * @return integer
     * @throws OutOfBoundsException
     */
    function index($x);

    /**
     * Return a new reversed sequence.
     *
     * @return Sequence
     */
    function reversed();

    /**
     * Inserts $x at the start.
     *
     * @param unknown $x
     *
     * @return Sequence
     */
    public function prepend($x);

    /**
     * Inserts $x at the end.
     *
     * @param unknown $x
     *
     * @return Sequence
     */
    public function append($x);
}

final class EmptyImmutableSequence implements Sequence {
    public function getIterator() {
        return new EmptyIterator;
    }

    public function count() {
        return 0;
    }

    public function contains($x) {
        return false;
    }

    public function index($x) {
        throw new OutOfBoundsException;
    }

    public function reversed() {
        return new self;
    }

    public function prepend($x) {
        return new ImmutableSequence(array($x), 1);
    }

    public function append($x) {
        return new ImmutableSequence(array($x), 1);
    }

    public function offsetExists($offset) {
        return false;
    }

    public function offsetGet($offset) {
        throw new OutOfRangeException;
    }

    public function offsetSet($offset, $value) {
        throw new BadMethodCallException;
    }

    public function offsetUnset($offset) {
        throw new BadMethodCallException;
    }
}

final class ImmutableSequence implements Sequence {
    private $elements = array();
    private $count = 0;

    public function __construct($elements, $count) {
        $this->elements = $elements;
        $this->count = $count;
    }

    public function getIterator() {
        foreach ($this->elements as $value) {
            yield $value;
        }
    }

    public function count() {
        return $this->count;
    }

    public function contains($x) {
        try {
            $this->index($x);
        } catch (OutOfBoundsException $e) {
            return false;
        }
        return true;
    }

    public function index($x) {
        foreach ($this->getIterator() as $index => $value) {
            if ($value === $x) {
                return $index;
            }
        }
        throw new OutOfBoundsException;
    }

    public function reversed() {
        $seq = new EmptyImmutableSequence;
        foreach ($this->getIterator() as $value) {
            $seq = $seq->prepend($value);
        }
        return $seq;
    }

    public function prepend($x) {
        return new ImmutableSequence(
            array_merge(array($x), $this->elements),
            $this->count + 1
        );
    }

    public function append($x) {
        return new ImmutableSequence(
            array_merge($this->elements, array($x)),
            $this->count + 1
        );
    }

    public function offsetExists($offset) {
        return array_key_exists($offset, $this->elements);
    }

    public function offsetGet($offset) {
        if ($this->offsetExists($offset)) {
            return $this->elements[$offset];
        }

        throw new OutOfRangeException;
    }

    public function offsetSet($offset, $value) {
        throw new BadMethodCallException;
    }

    public function offsetUnset($offset) {
        throw new BadMethodCallException;
    }
}