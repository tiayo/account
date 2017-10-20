 $(function () {
    var chart = c3.generate({
        bindto: '#roated-chart',
        data: {
        columns: [
            ['data1', 30, 200, 100, 400, 150, 250],
            ['data2', 50, 20, 10, 40, 15, 25]
        ],
        types: {
            data1: 'bar'
        }
    },
    axis: {
        rotated: true,
        x: {
            tick: {
                values: [1, 2, 4, 8, 16, 32]
            }
        },
        y: {
            max: 100
        }
    }
    });
 });