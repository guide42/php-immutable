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

    public function testReversed()
    {
        $this->assertInstanceOf('EmptyImmutableSequence', $this->seq->reversed());
    }

    public function testIndex()
    {
        $this->setExpectedException('OutOfRangeException');
        $this->seq->index('hello');
    }

    public function testPrependAndAppend()
    {
        $this->assertEquals($this->seq->prepend('1'), $this->seq->append('1'));
    }

    public function testPrepend()
    {
        $this->assertEquals(new ImmutableSequence(array('1')), $this->seq->prepend('1'));
    }

    public function testAppend()
    {
        $this->assertEquals(new ImmutableSequence(array('1')), $this->seq->append('1'));
    }
}