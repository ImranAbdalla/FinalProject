<?php

use PHPUnit\Framework\TestCase;

class BookingTest extends TestCase
{
    private $databaseMock;

    protected function setUp(): void
    {
        // Mock the database connection
        $this->databaseMock = $this->createMock(mysqli::class);

        // Mock session to simulate logged-in patient
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /** @test */
    public function test_patient_access_booking_page_when_logged_in()
    {
        // Simulate logged-in patient
        $_SESSION['user'] = 'patient@edoc.com';
        $_SESSION['usertype'] = 'p';

        ob_start();
        include 'patient/booking.php';  // Path to the file being tested
        ob_end_clean();

        $this->assertStringContainsString('Session Details', ob_get_clean());
    }

    /** @test */
    public function test_patient_access_booking_page_when_not_logged_in()
    {
        // Simulate not logged-in patient
        unset($_SESSION['user']);
        unset($_SESSION['usertype']);

        ob_start();
        include 'patient/booking.php';  // Path to the file being tested
        $output = ob_get_clean();

        $this->assertStringContainsString('location: ../login.php', $output);
    }

    /** @test */
    public function test_create_appointment()
    {
        // Simulate form input data for an appointment booking
        $_POST = [
            'scheduleid' => 1,
            'apponum' => 1,
            'date' => '2024-11-19'
        ];

        // Simulate the database response for a schedule and doctor info
        $this->simulateDatabaseResponseForBooking(1, 'Dr. Smith', 'doctor@edoc.com', '2024-11-19', '10:00');

        ob_start();
        include 'patient/booking.php';  // Path to the file being tested
        ob_end_clean();

        $this->assertStringContainsString('Book now', ob_get_clean());
    }

    /** @test */
    public function test_booking_form_submission()
    {
        // Simulate a POST request for booking an appointment
        $_POST = [
            'scheduleid' => 1,
            'apponum' => 2,
            'date' => '2024-11-19',
            'booknow' => 'Submit'
        ];

        // Mock the database response to simulate appointment creation
        $this->simulateDatabaseResponseForBooking(1, 'Dr. Smith', 'doctor@edoc.com', '2024-11-19', '10:00');

        ob_start();
        include 'patient/booking.php';  // Path to the file being tested
        ob_end_clean();

        $this->assertStringContainsString('Appointment successfully booked', ob_get_clean());
    }

    private function simulateDatabaseResponseForBooking($scheduleid, $docname, $docemail, $scheduledate, $scheduletime)
    {
        $this->databaseMock->method('query')
            ->willReturnCallback(function ($query) use ($scheduleid, $docname, $docemail, $scheduledate, $scheduletime) {
                if (strpos($query, 'select * from schedule') !== false) {
                    return new class($scheduleid, $docname, $docemail, $scheduledate, $scheduletime) {
                        private $scheduleid, $docname, $docemail, $scheduledate, $scheduletime;

                        public function __construct($scheduleid, $docname, $docemail, $scheduledate, $scheduletime)
                        {
                            $this->scheduleid = $scheduleid;
                            $this->docname = $docname;
                            $this->docemail = $docemail;
                            $this->scheduledate = $scheduledate;
                            $this->scheduletime = $scheduletime;
                        }

                        public function fetch_assoc()
                        {
                            return [
                                'scheduleid' => $this->scheduleid,
                                'docname' => $this->docname,
                                'docemail' => $this->docemail,
                                'scheduledate' => $this->scheduledate,
                                'scheduletime' => $this->scheduletime
                            ];
                        }
                    };
                }
            });
    }
}
