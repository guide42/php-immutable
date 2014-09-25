<?php

class ImmutableSequenceTest extends PHPUnit_Framework_TestCase
{
    private $seq;

    public function setUp()
    {
        $this->seq = new ImmutableSequence(array(1, 2, 3), 3);
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

    public function testIndex()
    {
        $this->assertEquals(0, $this->seq->index(1));
        $this->assertEquals(1, $this->seq->index(2));
        $this->assertEquals(2, $this->seq->index(3));
    }

    /**
     * @expectedException OutOfBoundsException
     */
    public function testIndexOutOfBounds()
    {
        $this->seq->index(42);
    }

    public function testReversed()
    {
        $exp = new ImmutableSequence(array(3, 2, 1), 3);
        $rev = $this->seq->reversed();

        $this->assertInstanceOf('Sequence', $rev);
        $this->assertEquals($exp, $rev);
    }

    /**
     * @dataProvider testSlicedProvider
     */
    public function testSliced($expected, $start, $stop)
    {
        $exp = new ImmutableSequence($expected, $c = count($expected));
        $new = $this->seq->sliced($start, $stop);

        $this->assertInstanceOf('Sequence', $new);
        $this->assertEquals($exp, $new);
        $this->assertCount($c, $new);
    }

    public function testSlicedProvider()
    {
        return array(
            array(array(1, 2, 3), -4, null),
            array(array(1, 2, 3), 0, null),
            array(array(2, 3), 1, 3),
            array(array(3), 2, 4),
            array(array(2, 3), -2, null),
            array(array(2), 1, -1),
        );
    }

    /**
     * @dataProvider testSlicedEmptyProvider
     */
    public function testSlicedEmpty($start, $stop)
    {
        $exp = new EmptyImmutableSequence;
        $new = $this->seq->sliced($start, $stop);

        $this->assertEquals($exp, $new);
        $this->assertCount(0, $new);
    }

    public function testSlicedEmptyProvider()
    {
        return array(
            array(3, null),
            array(-1, -2),
            array(2, -4),
            array(1, -3),
            array(2, 2),
        );
    }

    public function testPrepend()
    {
        $exp = new ImmutableSequence(array(4, 1, 2, 3), 4);
        $val = $this->seq->prepend(4);

        $this->assertEquals($exp, $val);
    }

    public function testAppend()
    {
        $exp = new ImmutableSequence(array(1, 2, 3, 4), 4);
        $val = $this->seq->append(4);

        $this->assertEquals($exp, $val);
    }

    public function testExists()
    {
        $this->assertFalse(isset($this->seq[42]));

        $this->assertTrue(isset($this->seq[0]));
        $this->assertTrue(isset($this->seq[1]));
        $this->assertTrue(isset($this->seq[2]));
    }

    public function testGet()
    {
        $this->assertEquals(1, $this->seq[0]);
        $this->assertEquals(2, $this->seq[1]);
        $this->assertEquals(3, $this->seq[2]);
    }

    /**
     * @expectedException OutOfRangeException
     */
    public function testGetOutOfRange()
    {
        $this->seq[3];
    }
}