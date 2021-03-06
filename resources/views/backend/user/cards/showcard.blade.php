@extends('backend.user.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            Single Card
                        </div>
                        <div class="float-right">
                            <a href="#" class="h2 text-success" id="printMe" title="Print All Cards"><i class="fa fa-print ml-3"></i> </a>
                        </div>
                    </div>
                    @include('layouts.flash_messages')
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="print">
                                    @include('backend.user.cards.include.template',$employe)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function(){
            $('#printMe').on("click", function () {
                $('.print').print();
            });
        });
    </script>
@endsection