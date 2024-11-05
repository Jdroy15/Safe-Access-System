// Ensure the DOM is ready before executing the jQuery code
$(document).ready(function () {
    // Click event handler for the red_box button
    $('#red_box').click(function () {
        appendPattern('RED');
    });
    // Click event handler for the blue_box button
    $('#blue_box').click(function () {
        appendPattern('BLUE');
    });
    // Click event handler for the green_box button
    $('#green_box').click(function () {
        appendPattern('GREEN');
    });
    function appendPattern(color) {
        // You can define your pattern logic based on the selected color
        // For simplicity, I'm just appending the color to the input value
        $('#input').val($('#input').val() + color);
    }
});
