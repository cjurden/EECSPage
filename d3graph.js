InitChart();

function InitChart() {
  //opeining tsv file to add data
  d3.tsv("prices.tsv", function(error, data) {
    if(error) throw error;
    
    //coerce data to numbers
    data.forEach(function(d) {
      d.x = +d.x;
      d.y = +d.y;
    });
  });
}
