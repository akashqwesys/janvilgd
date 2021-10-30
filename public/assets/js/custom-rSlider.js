var colorSlider = new rSlider({
    target: '#colorSlider',
    values: ['J', 'I', 'H', 'G', 'F', 'E', 'D'],
    range: true,
    tooltip: false,
    scale: true,
    labels: true,
    set: ['J', 'D'],
    onChange: function (vals) {
        console.log(vals);
    }
});
colorSlider.onChange(function (values) { console.log(values); });
var cutSlider = new rSlider({
    target: '#cutSlider',
    values: ['Fair', 'Good', 'Very Good', 'Ideal', 'Super Ideal', 'Excellent'],
    range: true,
    tooltip: false,
    scale: true,
    labels: true,
    set: ['J', 'D']
});
var claritySlider = new rSlider({
    target: '#claritySlider',
    values: ['SI2', 'SI1', 'VS2', 'VS1', 'VVS2', 'VVS1', 'IF', 'FL'],
    range: true,
    tooltip: false,
    scale: true,
    labels: true,
    set: ['J', 'D']
});
var cartSlider = new rSlider({
    target: '#cartSlider',
    values: { min: 0, max: 3000 },
    step: 10,
    range: true,
    tooltip: true,
    scale: true,
    labels: false,
    set: ['0', '3000']
});
var priceSlider = new rSlider({
    target: '#priceSlider',
    values: { min: 0, max: 3000 },
    step: 10,
    range: true,
    tooltip: true,
    scale: true,
    labels: false,
    set: ['0', '3000']
});