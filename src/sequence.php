<?php

interface Sequence extends Countable, IteratorAggregate, Container {
    /**
     * Return a new reversed sequence.
     *
     * @return Sequence
     */
    function reversed();

    /**
     * Return $x's index or throw an exception.
     *
     * @param unknown $x
     *
     * @return integer
     * @throws OutOfRangeException
     */
    function index($x);

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

    public function reversed() {
        return new self;
    }

    public function index($x) {
        throw new OutOfBoundsException;
    }

    public function prepend($x) {
        return new ImmutableSequence(array($x), 1);
    }

    public function append($x) {
        return new ImmutableSequence(array($x), 1);
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

    public function reversed() {
        $seq = new EmptyImmutableSequence;
        foreach ($this->getIterator() as $value) {
            $seq = $seq->prepend($value);
        }
        return $seq;
    }

    public function index($x) {
        foreach ($this->getIterator() as $index => $value) {
            if ($value === $x) {
                return $index;
            }
        }
        throw new OutOfBoundsException;
    }

    public function prepend($x) {
        return new ImmutableSequence(array_merge(array($x), $this->elements), $this->count + 1);
    }

    public function append($x) {
        return new ImmutableSequence(array_merge($this->elements, array($x)), $this->count + 1);
    }
}