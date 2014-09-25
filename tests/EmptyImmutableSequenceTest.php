<?php

class EmptyImmutableSequenceTest extends PHPUnit_Framework_TestCase
{
    private $seq;

    public function setUp()
    {
        $this->seq = new EmptyImmutableSequence();
    }

    public function tearDown()
    {
        $this->seq = null;
    }

    public function testIterator()
    {
        $this->assertInstanceOf('EmptyIterator', $this->seq->getIterator());
    }

    public function testCount()
    {
        $this->assertEquals(0, $this->seq->count());
    }

    public function testContains()
    {
        $this->assertFalse($this->seq->contains('hello'));
        $this->assertFalse($this->seq->contains(42));
    }

    public function testIndex()
    {
        $this->setExpectedException('OutOfBoundsException');
        $this->seq->index('hello');
    }

    public function testReversed()
    {
        $new = $this->seq->reversed();

        $this->assertInstanceOf('EmptyImmutableSequence', $new);
        $this->assertNotSame($this->seq, $new);
    }

    public function testPrependAndAppend()
    {
        $this->assertEquals($this->seq->prepend('1'), $this->seq->append('1'));
    }

    public function testPrepend()
    {
        $exp = new ImmutableSequence(array('1'), 1);
        $val = $this->seq->prepend('1');

        $this->assertEquals($exp, $val);
    }

    public function testAppend()
    {
        $exp = new ImmutableSequence(array('1'), 1);
        $val = $this->seq->append('1');

        $this->assertEquals($exp, $val);
    }

    public function testExists()
    {
        $this->assertFalse(isset($this->seq[42]));
    }

    public function testGet()
    {
        $this->setExpectedException('OutOfRangeException');
        $this->seq[0];
    }
}