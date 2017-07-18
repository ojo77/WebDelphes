<?php
// JS
?>
<script type="text/javascript">
  var clwColors = {"CPU":"#00BB00"
                  ,"Scheduler":"#78E078"
                  ,"User I/O":"#0043D0"
                  ,"Other":"#F071B0"
                  ,"Concurrency":"#801800"
                  ,"Commit":"#E06800"
                  ,"System I/O":"#0090E0"
                  ,"Network":"#989070"
                  ,"Configuration":"#606810"
                  ,"Application":"#FF0000"} ;
  
  var  l101 = dc.pieChart("#l101") ;
  var l1101 = dc.rowChart("#l1101");
  var l1102 = dc.rowChart("#l1102");
  var l1103 = dc.rowChart("#l1103");
  var l1104 = dc.rowChart("#l1104");
  var l1105 = dc.rowChart("#l1105");
  var l1106 = dc.rowChart("#l1106");
 
  var  l201 = dc.rowChart("#l201") ;
  var  l210 = dc.rowChart("#l210") ;
  var  l220 = dc.rowChart("#l220") ;
  var  l230 = dc.rowChart("#l230") ;
  var  l240 = dc.rowChart("#l240") ;
  var  l250 = dc.rowChart("#l250") ;
 
  var  l300 = dc.rowChart("#l300") ;
  var  l310 = dc.rowChart("#l310") ;
  var  l320 = dc.rowChart("#l320") ;
  var  l330 = dc.rowChart("#l330") ;
  var  l340 = dc.rowChart("#l340") ;
  var  l350 = dc.rowChart("#l350") ;
  
  var mH3=Math.max(150 , ($(window).height() - 150) / 3 );
  var topN=Math.round(mH3/16);	
	
	
  $.ajax({
    type: "GET",
    url: "ajax/oraSql.php",
	data: { qname: "sessions" }, 
    dataType: "text",
    success: function(csvdata) { 
    
	'use strict';
	
	var jsdata=Papa.parse(csvdata, {
	                       delimiter: ",",	// auto-detect
	                       newline: "\n",	// auto-detect
	                       quoteChar: '"',
	                       header: true,
	                       dynamicTyping: false,
	                       preview: 0,
	                       encoding: "",
	                       worker: false,
	                       comments: false,
	                       step: undefined,
	                       complete: undefined,
	                       error: undefined,
	                       download: false,
	                       skipEmptyLines: false,
	                       chunk: undefined,
	                       fastMode: undefined,
	                       beforeFirstChunk: undefined,
	                       withCredentials: undefined
                         }).data;
		       ;

			   
	  var ndx = crossfilter( jsdata );
	  
      var all = ndx.groupAll();
	  var tot = all.reduceCount();
	  
	  var l101D = ndx.dimension(function(d) {return d.STATUS;});
	  var l101G = l101D.group().reduceCount();
	  
	  l101
        .width( $("#l101").width() ).height( mH3 )
        .dimension(l101D)
        //.margins({top: 2, right: 5, bottom: 18, left: 2})
        //.cap( topN )
        //.elasticX(true)
        .ordering(function(d) { return  d.key; })
		.ordinalColors(['green','orange'])
        .label(function (d) { return (d.value / tot.value() * 100).toFixed(2) + "% : " + d.key  ;})
        //.label(function (d) { return (d.value).toFixed(2) + "% : " + d.key  ;})
        .group(l101G);
	  
	  var l1101D = ndx.dimension(function(d) {return d.SQL_ID;});
	  var l1101G = l1101D.group().reduceCount();
	  
	  l1101
        .width( $("#l1101").width() ).height( mH3 )
        .dimension(l1101D)
        .margins({top: 2, right: 5, bottom: 18, left: 2})
        .cap( topN )
        .elasticX(true)
        .ordering(function(d) { return - d.value; })
        .label(function (d) { return (d.value / tot.value() * 100).toFixed(2) + "% : " + d.key  ;})
        //.label(function (d) { return (d.value).toFixed(2) + "% : " + d.key  ;})
        .group(l1101G);
		
	  var l1102D = ndx.dimension(function(d) {return d.FMS;});
	  var l1102G = l1102D.group().reduceCount();
	  
	  l1102
        .width( $("#l1102").width() ).height( mH3 )
        .dimension(l1102D)
        .margins({top: 2, right: 5, bottom: 18, left: 2})
        .cap( topN )
        .elasticX(true)
        .ordering(function(d) { return - d.value; })
        .label(function (d) { return (d.value / tot.value() * 100).toFixed(2) + "% : " + d.key  ;})
        //.label(function (d) { return (d.value).toFixed(2) + "% : " + d.key  ;})
        .group(l1102G);
		
	  var l1103D = ndx.dimension(function(d) {return d.PHV;});
	  var l1103G = l1103D.group().reduceCount();
	  
	  l1103
        .width( $("#l1103").width() ).height( mH3 )
        .dimension(l1103D)
        .margins({top: 2, right: 5, bottom: 18, left: 2})
        .cap( topN )
        .elasticX(true)
        .ordering(function(d) { return - d.value; })
        .label(function (d) { return (d.value / tot.value() * 100).toFixed(2) + "% : " + d.key  ;})
        //.label(function (d) { return (d.value).toFixed(2) + "% : " + d.key  ;})
        .group(l1103G);
		
	  var l1104D = ndx.dimension(function(d) {return d.SERVICE;});
	  var l1104G = l1104D.group().reduceCount();
	  
	  l1104
        .width( $("#l1104").width() ).height( mH3 )
        .dimension(l1104D)
        .margins({top: 2, right: 5, bottom: 18, left: 2})
        .cap( topN )
        .elasticX(true)
        .ordering(function(d) { return - d.value; })
        .label(function (d) { return (d.value / tot.value() * 100).toFixed(2) + "% : " + d.key  ;})
        //.label(function (d) { return (d.value).toFixed(2) + "% : " + d.key  ;})
        .group(l1104G);
		
	  var l1105D = ndx.dimension(function(d) {return d.MODULE;});
	  var l1105G = l1105D.group().reduceCount();
	  
	  l1105
        .width( $("#l1105").width() ).height( mH3 )
        .dimension(l1105D)
        .margins({top: 2, right: 5, bottom: 18, left: 2})
        .cap( topN )
        .elasticX(true)
        .ordering(function(d) { return - d.value; })
        .label(function (d) { return (d.value / tot.value() * 100).toFixed(2) + "% : " + d.key  ;})
        //.label(function (d) { return (d.value).toFixed(2) + "% : " + d.key  ;})
        .group(l1105G);
		
	  var l1106D = ndx.dimension(function(d) {return d.ACTION;});
	  var l1106G = l1106D.group().reduceCount();
	  
	  l1106
        .width( $("#l1106").width() ).height( mH3 )
        .dimension(l1106D)
        .margins({top: 2, right: 5, bottom: 18, left: 2})
        .cap( topN )
        .elasticX(true)
        .ordering(function(d) { return - d.value; })
        .label(function (d) { return (d.value / tot.value() * 100).toFixed(2) + "% : " + d.key  ;})
        //.label(function (d) { return (d.value).toFixed(2) + "% : " + d.key  ;})
        .group(l1106G);
		
	  var l201D = ndx.dimension(function(d) {return d.SESSION_ID;});
	  var l201G = l201D.group().reduceCount();
	  
	  l201
        .width( $("#l201").width() ).height( mH3 )
        .dimension(l201D)
        .margins({top: 2, right: 5, bottom: 18, left: 2})
        .cap( topN )
        .elasticX(true)
        .ordering(function(d) { return - d.value; })
        .label(function (d) { return (d.value / tot.value() * 100).toFixed(2) + "% : " + d.key  ;})
        //.label(function (d) { return (d.value).toFixed(2) + "% : " + d.key  ;})
        .group(l201G);
		
	  var l210D = ndx.dimension(function(d) {return d.COMMAND;});
	  var l210G = l210D.group().reduceCount();
	  
	  l210
        .width( $("#l210").width() ).height( mH3 )
        .dimension(l210D)
        .margins({top: 2, right: 5, bottom: 18, left: 2})
        .cap( topN )
        .elasticX(true)
        .ordering(function(d) { return - d.value; })
        .label(function (d) { return (d.value / tot.value() * 100).toFixed(2) + "% : " + d.key  ;})
        //.label(function (d) { return (d.value).toFixed(2) + "% : " + d.key  ;})
        .group(l210G);
		
	  var l220D = ndx.dimension(function(d) {return d.SCHEMANAME;});
	  var l220G = l220D.group().reduceCount();
	  
	  l220
        .width( $("#l220").width() ).height( mH3 )
        .dimension(l220D)
        .margins({top: 2, right: 5, bottom: 18, left: 2})
        .cap( topN )
        .elasticX(true)
        .ordering(function(d) { return - d.value; })
        .label(function (d) { return (d.value / tot.value() * 100).toFixed(2) + "% : " + d.key  ;})
        //.label(function (d) { return (d.value).toFixed(2) + "% : " + d.key  ;})
        .group(l220G);
		
	  var l230D = ndx.dimension(function(d) {return d.DB_USER;});
	  var l230G = l230D.group().reduceCount();
	  
	  l230
        .width( $("#l230").width() ).height( mH3 )
        .dimension(l230D)
        .margins({top: 2, right: 5, bottom: 18, left: 2})
        .cap( topN )
        .elasticX(true)
        .ordering(function(d) { return - d.value; })
        .label(function (d) { return (d.value / tot.value() * 100).toFixed(2) + "% : " + d.key  ;})
        //.label(function (d) { return (d.value).toFixed(2) + "% : " + d.key  ;})
        .group(l230G);
		
	  var l240D = ndx.dimension(function(d) {return d.WAIT_CLASS;});
	  var l240G = l240D.group().reduceCount();
	  
	  l240
        .width( $("#l240").width() ).height( mH3 )
        .dimension(l240D)
        .margins({top: 2, right: 5, bottom: 18, left: 2})
        .cap( topN )
        .elasticX(true)
        .ordering(function(d) { return - d.value; })
        .colors(function (d){ return clwColors[d]; })
        .colorAccessor(function (d) {
                return d.key;
        })      
		.label(function (d) { return (d.value / tot.value() * 100).toFixed(2) + "% : " + d.key  ;})
        //.label(function (d) { return (d.value).toFixed(2) + "% : " + d.key  ;})
        .group(l240G);
		
	  var l250D = ndx.dimension(function(d) {return d.EVENT;});
	  var l250G = l250D.group().reduceCount();
	  
	  l250
        .width( $("#l250").width() ).height( mH3 )
        .dimension(l250D)
        .margins({top: 2, right: 5, bottom: 18, left: 2})
        .cap( topN )
        .elasticX(true)
        .ordering(function(d) { return - d.value; })
        .label(function (d) { return (d.value / tot.value() * 100).toFixed(2) + "% : " + d.key  ;})
        //.label(function (d) { return (d.value).toFixed(2) + "% : " + d.key  ;})
        .group(l250G);
		
	  var l300D = ndx.dimension(function(d) {return d.LOCAL_PROCESS_PID;});
	  var l300G = l300D.group().reduceCount();
	  
	  l300
        .width( $("#l300").width() ).height( mH3 )
        .dimension(l300D)
        .margins({top: 2, right: 5, bottom: 18, left: 2})
        .cap( topN )
        .elasticX(true)
        .ordering(function(d) { return - d.value; })
        .label(function (d) { return (d.value / tot.value() * 100).toFixed(2) + "% : " + d.key  ;})
        //.label(function (d) { return (d.value).toFixed(2) + "% : " + d.key  ;})
        .group(l300G);
		
	  var l310D = ndx.dimension(function(d) {return d.TERMINAL;});
	  var l310G = l310D.group().reduceCount();
	  
	  l310
        .width( $("#l310").width() ).height( mH3 )
        .dimension(l310D)
        .margins({top: 2, right: 5, bottom: 18, left: 2})
        .cap( topN )
        .elasticX(true)
        .ordering(function(d) { return - d.value; })
        .label(function (d) { return (d.value / tot.value() * 100).toFixed(2) + "% : " + d.key  ;})
        //.label(function (d) { return (d.value).toFixed(2) + "% : " + d.key  ;})
        .group(l310G);
		
	  var l320D = ndx.dimension(function(d) {return d.MACHINE;});
	  var l320G = l320D.group().reduceCount();
	  
	  l320
        .width( $("#l320").width() ).height( mH3 )
        .dimension(l320D)
        .margins({top: 2, right: 5, bottom: 18, left: 2})
        .cap( topN )
        .elasticX(true)
        .ordering(function(d) { return - d.value; })
        .label(function (d) { return (d.value / tot.value() * 100).toFixed(2) + "% : " + d.key  ;})
        //.label(function (d) { return (d.value).toFixed(2) + "% : " + d.key  ;})
        .group(l320G);
		
	  var l330D = ndx.dimension(function(d) {return d.OSUSER;});
	  var l330G = l330D.group().reduceCount();
	  
	  l330
        .width( $("#l330").width() ).height( mH3 )
        .dimension(l330D)
        .margins({top: 2, right: 5, bottom: 18, left: 2})
        .cap( topN )
        .elasticX(true)
        .ordering(function(d) { return - d.value; })
        .label(function (d) { return (d.value / tot.value() * 100).toFixed(2) + "% : " + d.key  ;})
        //.label(function (d) { return (d.value).toFixed(2) + "% : " + d.key  ;})
        .group(l330G);
		
	  var l340D = ndx.dimension(function(d) {return d.PROGRAM;});
	  var l340G = l340D.group().reduceCount();
	  
	  l340
        .width( $("#l340").width() ).height( mH3 )
        .dimension(l340D)
        .margins({top: 2, right: 5, bottom: 18, left: 2})
        .cap( topN )
        .elasticX(true)
        .ordering(function(d) { return - d.value; })
        .label(function (d) { return (d.value / tot.value() * 100).toFixed(2) + "% : " + d.key  ;})
        //.label(function (d) { return (d.value).toFixed(2) + "% : " + d.key  ;})
        .group(l340G);
		
	  var l350D = ndx.dimension(function(d) {return d.DISTANT_PROCESS_PID;});
	  var l350G = l350D.group().reduceCount();
	  
	  l350
        .width( $("#l350").width() ).height( mH3 )
        .dimension(l350D)
        .margins({top: 2, right: 5, bottom: 18, left: 2})
        .cap( topN )
        .elasticX(true)
        .ordering(function(d) { return - d.value; })
        .label(function (d) { return (d.value / tot.value() * 100).toFixed(2) + "% : " + d.key  ;})
        //.label(function (d) { return (d.value).toFixed(2) + "% : " + d.key  ;})
        .group(l350G);
		
	  dc.renderAll();
	  
	  $(".topn").html('TOP ' + topN);

	}
  });

</script>