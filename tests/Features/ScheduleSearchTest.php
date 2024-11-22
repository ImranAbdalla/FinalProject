<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;

class ScheduleSearchTest extends TestCase
{
    private $databaseMock;

    protected function setUp(): void
    {
        // Mocking the database connection
        $this->databaseMock = $this->createMock(\mysqli::class);
    }

    public function testRedirectsToLoginIfNotLoggedIn()
    {
        // Simulate no session
        $_SESSION = [];

        // Include the script and capture output
        ob_start();
        include __DIR__ . '/../../patient/schedule.php'; // Adjust the path to match your file structure
        $output = ob_get_clean();

        // Check for redirection header
        $this->assertStringContainsString('location: ../login.php', xdebug_get_headers()[0] ?? '');
    }

    public function testShowsSchedulesForLoggedInUser()
    {
        // Simulate logged-in patient session
        $_SESSION = [
            'user' => 'patient@edoc.com',
            'usertype' => 'p',
        ];

        // Mock database response
        $mockResult = $this->createMock(\mysqli_result::class);
        $mockResult->method('num_rows')->willReturn(1);
        $mockResult->method('fetch_assoc')->willReturn([
            'scheduleid' => 1,
            'title' => 'Test Session',
            'docname' => 'Ilyan',
            'scheduledate' => '2050-01-01',
            'scheduletime' => '10:00:00',
        ]);

        $this->databaseMock->method('query')->willReturn($mockResult);

        // Include the script and capture output
        ob_start();
        include __DIR__ . '/../../patient/schedule.php'; // Adjust the path to match your file structure
        $output = ob_get_clean();

        // Assert the HTML output contains expected session details
        $this->assertStringContainsString('Session Title', $output);
        $this->assertStringContainsString('Ilyan', $output);
        $this->assertStringContainsString('050-01-01', $output);
    }

    public function testSearchFunctionality()
    {
        // Simulate logged-in patient session
        $_SESSION = [
            'user' => 'patient@edoc.com',
            'usertype' => 'p',
        ];

        // Simulate a search POST request
        $_POST = [
            'search' => 'Ilyas',
        ];

        // Mock database response for search query
        $mockResult = $this->createMock(\mysqli_result::class);
        $mockResult->method('num_rows')->willReturn(1);
        $mockResult->method('fetch_assoc')->willReturn([
            'scheduleid' => 1,
            'title' => 'Test Session',
            'docname' => 'Ilyas',
            'scheduledate' => '2050-01-01',
            'scheduletime' => '10:00:00',
        ]);

        $this->databaseMock->method('query')->willReturn($mockResult);

        // Include the script and capture output
        ob_start();
        include __DIR__ . '/../../patient/schedule.php'; 
        $output = ob_get_clean();

        // Assert that search results are correctly displayed
        $this->assertStringContainsString('Search Result:', $output);
        $this->assertStringContainsString('Doctor Name', $output);
    }

    public function testHandlesEmptySearchResultsGracefully()
    {
        // Simulate logged-in patient session
        $_SESSION = [
            'user' => 'patient@edoc.com',
            'usertype' => 'p',
        ];

        // Simulate a search POST request
        $_POST = [
            'search' => 'Nonexistent',
        ];

        // Mock an empty database result for search query
        $mockResult = $this->createMock(\mysqli_result::class);
        $mockResult->method('num_rows')->willReturn(0);

        $this->databaseMock->method('query')->willReturn($mockResult);

        // Include the script and capture output
        ob_start();
        include __DIR__ . '/../../patient/schedule.php'; 
        $output = ob_get_clean();

        // Assert the page shows a "no results" message
        $this->assertStringContainsString('We couldnt find anything related to your keywords!', $output);
    }
}
