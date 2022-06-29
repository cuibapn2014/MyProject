/**
 * For usage, visit Chart.js docs https://www.chartjs.org/docs/latest/
 */
export const chartLine = (data) => {
  const months = []
  const values = []

  data.map(item => {
    months.push("Tháng " + item.month)
    values.push(item.total)
  })

  const lineConfig = {
    type: 'line',
    data: {
      labels: months,//['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7'],
      datasets: [
        {
          label: 'Doanh thu',
          /**
           * These colors come from Tailwind CSS palette
           * https://tailwindcss.com/docs/customizing-colors/#default-color-palette
           */
          backgroundColor: '#7e3af2',
          borderColor: '#7e3af2',
          data: values,//[43, 48, 40, 54, 67, 73, 70],
          fill: false,
        },
        // {
        //   label: 'Paid',
        //   fill: false,
        //   /**
        //    * These colors come from Tailwind CSS palette
        //    * https://tailwindcss.com/docs/customizing-colors/#default-color-palette
        //    */
        //   backgroundColor: '#7e3af2',
        //   borderColor: '#7e3af2',
        //   data: [24, 50, 64, 74, 52, 51, 65],
        // },
      ],
    },
    options: {
      locale: 'vi-VN',
      responsive: true,
      /**
       * Default legends are ugly and impossible to style.
       * See examples in charts.html to add your own legends
       *  */
      legend: {
        display: false,
      },
      tooltips: {
        mode: 'index',
        intersect: false,
        callbacks: {
          label: function (tooltipItem, data) {
            return tooltipItem.yLabel.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
          }
        }
      },
      hover: {
        mode: 'nearest',
        intersect: true,
      },
      scales: {
        yAxes: [{
          ticks: {
            callback: function (value, index, values) {
              return value.toLocaleString("vi-VN", { style: "currency", currency: "VND" });
            }
          },
        }],
      },
    },
  }

  // change this to the id of your chart element in HMTL
  const lineCtx = document.getElementById('line')
  window.myLine = new Chart(lineCtx, lineConfig)
}