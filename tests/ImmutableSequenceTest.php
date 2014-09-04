<?php

class ImmutableSequenceTest extends PHPUnit_Framework_TestCase
{
    private $seq;

    public function setUp()
    {
        $this->seq = new ImmutableSequence(array(1, 2, 3));
    }

    public function tearDown()
    {
        $this->seq = null;
    }

    public function testIterator()
    {
        $this->assertInstanceOf('Iterator', $this->seq->getIterator());
    }

    public function testCount()
    {
        $this->assertEquals(3, $this->seq->count());
    }

    public function testContains()
    {
        $this->assertFalse($this->seq->contains(42));
        $this->assertTrue($this->seq->contains(1));
        $this->assertTrue($this->seq->contains(2));
        $this->assertTrue($this->seq->contains(3));
    }

    public function testReversed()
    {
        $exp = new ImmutableSequence(array(3, 2, 1));
        $rev = $this->seq->reversed();

        $this->assertInstanceOf('Sequence', $rev);
        $this->assertEquals($exp, $rev);
    }

    public function testIndex()
    {
        $this->assertEquals(0, $this->seq->index(1));
        $this->assertEquals(1, $this->seq->index(2));
        $this->assertEquals(2, $this->seq->index(3));
    }

    public function testIndexOutOfRange()
    {
        $this->setExpectedException('OutOfRangeException');
        $this->seq->index(42);
    }

    public function testPrepend()
    {
        $this->assertEquals(new ImmutableSequence(array(4, 1, 2, 3)), $this->seq->prepend(4));
    }

    public function testAppend()
    {
        $this->assertEquals(new ImmutableSequence(array(1, 2, 3, 4)), $this->seq->append(4));
    }
}