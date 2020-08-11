@php
    use Mike42\Escpos\PrintConnectors\FilePrintConnector;
    use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
    use Mike42\Escpos\Printer;
    require 'C:\wamp64\www\CIT_Stock_System\vendor\autoload.php';
    try {
    // Enter the share name for your USB printer here


    $connector = null;
        $connector = new WindowsPrintConnector("EPSON L3110 Series");
        /* Print a "Hello world" receipt" */
        $printer = new Printer($connector);
        $printer -> text("Hello World\n");
        $printer -> cut();

        /* Close printer */
        $printer -> close();
    } catch (Exception $e) {
        echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
    }
@endphp