<?php

if (!function_exists('baseUrl')) {
    /**
     * Gets the base URL of the application.
     * 
     * Determines and returns the full base URL including protocol and host
     * by examining server variables. Handles both HTTP and HTTPS protocols.
     * Trims any trailing slashes from the URL.
     *
     * Example return value:
     * "https://example.com/myapp" or "http://localhost/myapp"
     *
     * @return string The base URL of the application
     */
    function baseUrl() {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        $scriptDir = dirname($_SERVER['SCRIPT_NAME']);

        return rtrim($protocol . "://" . $host . $scriptDir, '/');
    }
}

if (!function_exists('view')) {
    /**
     * Renders a PHP view file with provided data.
     * 
     * This function loads and renders a view file from the /src/Views/ directory.
     * The view name parameter should match the filename without the .php extension.
     * The data array will be extracted and made available as variables in the view.
     *
     * Example usage:
     * view('checkout', [
     *     'name' => 'john doe',
     *     'price' => 100,
     *     'qty' => 2
     * ])
     * 
     * This will render the file /src/Views/checkout.php with the provided data.
     * Inside the view, variables can be accessed through the $data array: $data['name'], $data['price'], $data['qty']
     * Note: Direct variable access ($name, $price, $qty) is not supported - use $data array instead
     *
     * @param string $name The name of the view file without .php extension
     * @param array $data Associative array of data to be passed to the view
     * 
     * @throws Exception If the view file does not exist in /src/Views/
     * 
     * @return string The rendered view content as a string
     */
    function view(string $name, array $data) {
        // Load the view file from the /src/Views/ directory
        $viewFile = __DIR__ . '/src/Views/' . $name . '.php';

        // Check if the view file exists
        if (!file_exists($viewFile)) {
            throw new Exception('View file not found: ' . $viewFile);
        }

        // Extract data array to variables
        extract($data);

        // Start output buffering
        ob_start();

        // Include the view file
        include $viewFile;

        // Return the rendered content
        return ob_get_clean();
    }
}


if (!function_exists('redirect')) {
    /**
     * Redirects to a specified URL or path.
     * 
     * If a full URL is provided (starting with http:// or https://), redirects to that URL.
     * Otherwise treats the input as a relative path and redirects relative to BASE_URL.
     * 
     * @param string $path URL or path to redirect to
     * @return void
     */
    function redirect(string $path = '/')
    {
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            $redirectUrl = $path;
        } else {
            $redirectUrl = baseUrl() . '/' . ltrim($path, '/'); 
        }

        header('Location: ' . $redirectUrl);
        exit;
    }
}
