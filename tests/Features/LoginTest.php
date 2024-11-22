<?php

use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    private $databaseMock;

    protected function setUp(): void
    {
        // Mock the database connection
        $this->databaseMock = $this->createMock(mysqli::class);
        // Ensure the session is started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /** @test */
    public function test_valid_login_for_patient()
    {
        $_POST = ['useremail' => 'patient@edoc.com', 'userpassword' => '123'];
        $this->simulateDatabaseResponse('p', true);

        ob_start();
        include 'login.php';
        ob_end_clean();

        $this->assertEquals('p', $_SESSION['usertype']);
        $this->assertEquals('patient@edoc.com', $_SESSION['user']);
    }

    /** @test */
    public function test_invalid_email()
    {
        $_POST = ['useremail' => 'invalid@example.com', 'userpassword' => 'password'];
        $this->simulateDatabaseResponse(null, false);

        ob_start();
        include 'login.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('We cant found any acount for this email.', $output);
    }

    /** @test */
    public function test_invalid_password()
    {
        $_POST = ['useremail' => 'patient@edoc.com', '123' => '1432143'];
        $this->simulateDatabaseResponse('p', false);

        ob_start();
        include 'login.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Wrong credentials: Invalid email or password', $output);
    }

    /** @test */
    public function test_unregistered_email()
    {
        $_POST = ['useremail' => 'unknown@example.com', 'userpassword' => 'password'];
        $this->simulateDatabaseResponse(null, false);

        ob_start();
        include 'login.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('We cant found any acount for this email.', $output);
    }

    private function simulateDatabaseResponse($usertype, $passwordMatches)
    {
        // Simulate the response from database
        $this->databaseMock->method('query')
            ->willReturnCallback(function ($query) use ($usertype, $passwordMatches) {
                if (strpos($query, 'select * from webuser') !== false) {
                    if ($usertype) {
                        return new class($usertype) {
                            private $usertype;
                            public function __construct($usertype) { $this->usertype = $usertype; }
                            public function num_rows() { return 1; }
                            public function fetch_assoc() { return ['usertype' => $this->usertype]; }
                        };
                    } else {
                        return new class {
                            public function num_rows() { return 0; }
                        };
                    }
                } elseif (strpos($query, 'select * from patient') !== false && $passwordMatches) {
                    return new class {
                        public function num_rows() { return 1; }
                    };
                }
                return new class {
                    public function num_rows() { return 0; }
                };
            });
    }
}
