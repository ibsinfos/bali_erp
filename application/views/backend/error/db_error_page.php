<style>

 #particles-js {
    width: 100%;
    height: 100%;
    background-color: #f0f0f0;
}
.page-404 .outer {
    position: absolute;
    top: 130px;
    display: table;
    width: 100%;
    height: 100%;
}
.page-404 .outer .middle {
    display: table-cell;

    vertical-align: middle;
}
.page-404 .outer .middle .inner {
    width: 300px;
    margin-right: auto;
    margin-left: auto;
}
.page-404 .outer .middle .inner .inner-circle {
    height: 300px;
    border-radius: 50%;
    background-color: #FFF;
    padding: 50px;
}
.page-404 .outer .middle .inner .inner-circle:hover i {
    color: #fff!important;
    background-color: #707cd2;
    box-shadow: 0 0 0 15px #707cd2;
}
.page-404 .outer .middle .inner .inner-circle:hover span {
    color: #707cd2;
}
.page-404 .outer .middle .inner .inner-circle span {
    font-size: 11em;
    font-weight: 700;
    line-height: 1.2em;

    display: block;

    -webkit-transition: all .4s;
            transition: all .4s;
    text-align: center;

    color: #e0e0e0;
}
.page-404 .outer .middle .inner .inner-status {
    font-size: 20px;
    display: block;
    margin-top: 0px;
    margin-bottom: 5px;
    text-align: center;
    color: #39bbdb;
}
.page-404 .outer .middle .inner .inner-detail {
    line-height: 1.4em;
    display: block;
    margin-bottom: 10px;
    text-align: center;
    color: #999999;
}
</style>

<div class="row">
    <div class="col-md-12">
        <div id="particles-js">
            <div class="page-404">
                <div class="outer">
                    <div class="middle">
                        <div class="inner">
                            <!--BEGIN CONTENT-->
                            <div class="inner-circle"><span><i class="fa fa-exclamation-triangle"></i></span></div>
                            <span class="inner-status" style="color:#707cd2;">Oops! You're lost</span>
                            <span class="inner-status" style="color:#707cd2;">Contact support@sharadtechnologies.com</span>
                            <span class="inner-detail" style="color:#707cd2;">
                                <a href="<?php echo base_url()?>" class="btn btn-info mtl" style="background-color:#707cd2">
                                    <i class="fa fa-home"></i>&nbsp;
                                    Return Dashboard
                                </a> 
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div>
</div>

<script src="<?php echo base_url('assets/js/particles.min.js')?>"></script> 
<script type="text/javascript">
particlesJS("particles-js", {
    "particles": {
		"number": {
			"value": 80,
			"density": {
				"enable": true,
				"value_area": 800
			}
		},
		"color": {
			"value": "#707cd2"
		},
		"shape": {
			"type": "circle",
			"stroke": {
				"width": 0,
				"color": "#707cd2"
			},
			"polygon": {
				"nb_sides": 5
			},
			"image": {
				"src": "img/github.svg",
				"width": 100,
				"height": 100
			}
		},
		"opacity": {
			"value": 0.5,
			"random": false,
			"anim": {
				"enable": false,
				"speed": 1,
				"opacity_min": 0.1,
				"sync": false
			}
		},
		"size": {
			"value": 3,
			"random": true,
			"anim": {
				"enable": false,
				"speed": 40,
				"size_min": 0.1,
				"sync": false
			}
		},
		"line_linked": {
			"enable": true,
			"distance": 150,
			"color": "#707cd2",
			"opacity": 0.4,
			"width": 1
		},
		"move": {
			"enable": true,
			"speed": 6,
			"direction": "none",
			"random": false,
			"straight": false,
			"out_mode": "out",
			"bounce": false,
			"attract": {
				"enable": false,
				"rotateX": 600,
				"rotateY": 1200
			}
		}
	},
	"interactivity": {
		"detect_on": "canvas",
		"events": {
			"onhover": {
			"color": "#707cd2",
				"enable": true,
				
				"mode": "grab"
			},
			"onclick": {
				"enable": true,
				"mode": "push"
			},
			"resize": true
		},
		"modes": {
			"grab": {
				"distance": 140,
				"line_linked": {
					"opacity": 1
				}
			},
			"bubble": {
				"distance": 400,
				"size": 40,
				"duration": 2,
				"opacity": 8,
				"speed": 3
			},
			"repulse": {
				"distance": 200,
				"duration": 0.4
			},
			"push": {
				"particles_nb": 4
			},
			"remove": {
				"particles_nb": 2
			}
		}
	},
	"retina_detect": true
});
</script>