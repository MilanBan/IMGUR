<?php
use app\models\Redis;
?>
                        </div>
                    </div>
                </div>
                <div class="col-2 bg-primary vh-90">
                    <a href="/advertising/adv-right">
                        <div class="d-flex justify-content-center vh-90" >
                            <div class="card bg-dark text-center text-white" style="height: 100%; width: 100%;">
                                <img src="https://picsum.photos/200/400" class="card-img" alt="" >
                                <div class="card-img-overlay">
                                    <p class="card-title text-right">ad</p>
                                    <h1 class="card-title">R <?= Redis::exists('sector:clicks:adv-right') ? Redis::cached('sector:clicks:adv-right') : '' ?></h1>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 bg-warning vh-10" >
                    <a href="/advertising/adv-footer" target="_blank">
                        <div class="d-flex justify-content-center vh-10" >
                            <div class="card bg-dark text-center text-white" style="height: 100px; width: 100%;">
                                <img src="https://picsum.photos/800/100" style="height: 100px; width: 100%;">
                                <div class="card-img-overlay p-2">
                                    <p class="card-title text-right">ad</p>
                                    <h1 class="card-title">F <?= Redis::exists('sector:clicks:adv-footer') ? Redis::cached('sector:clicks:adv-footer') : '' ?></h1>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    </body>
</html>