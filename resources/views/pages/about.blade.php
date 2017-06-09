@extends('layout')

@section('content')
<div class="container">
  <h4 class="content-header">About Us</h4>
  <div class="row">
        <div class="col-md-2 background-red sidebar">
            <nav class="nav-sidebar">
                <ul class="list-unstyled nav tabs">
                    <li class="active"><a href="#overview" data-toggle="tab">Overview</a></li>
                    <li class=""><a href="#mission" data-toggle="tab">Mission</a> </li>
                    <li class=""><a href="#vision" data-toggle="tab">Vision</a></li>
                    
                </ul>
            </nav>
        </div>
        <div class="col-md-10 tab-content">

            <div class="tab-pane about active text-style" id="overview">
                <h2>Overview</h2>
                <p>
                    <p>HiDok Inc. is a new and dynamic company that seeks to change how medical records and documents are handled by modernizing and streamlining the way they are accessed by our clients. By using our software products, the handle time in which you need to retrieve and review a patients medical records is greatly reduced, allowing for more speed and efficiency in your medical practice.</p>
                    <p>This allows you to maximize profits with minimal effort and time. In the age of electronic information exchange there is no need to wait for paper documents. </p>
                    <p>We would like to encourage you to look over our product and take advantage of the benefits that it can offer to you.</p>
                    <p>My Patient: Our 1st Product Description</p>
                    <p>Our 1st product MyPatient has two options (online and offline mode). We created My Patient to minimize the work of the doctors, nurses, midwives and even your secretaries in your hospitals, clinics and lying-in.</p>
                    <p>Online mode is for our clients who has stable internet connection in their clinics or institution. It is easy to use and you can transfer patient’s data to other institution where your patient is admitted or had consultation provided your patient consented.</p>
                    <p>Offline mode is for our clients who doesn’t have internet or unstable internet connection in their clinics or institution.</p> 
                    <p>Our product My Patient will make it more easier to view patients data that you want, accessible and easier to enter the data of the patients because you do not have to write each word.</p>
                </p>
            </div>    

            <div class="tab-pane about text-style" id="mission">
                <h2>Mission</h2>
                <p>
                   HiDok Inc. provides a software product to our clients to modernize the healthcare industry in the Philippines. We also maintain a friendly and creative work environment, new ideas, and hard work.                </p>

            </div>    

            <div class="tab-pane about text-style" id="vision">
                <h2>Vision</h2>
                <p>
                    Digitalize healthcare practice in the Philippines by 2020.    
                </p>

            </div>  
        </div>
  </div>
</div>
@endsection

@section('javascripts')
    <script>


        var childMixin = {

            mounted() {
            },

            created: function() {
            },

            data(){
                return {
                }
            },

            events: {

            },

            methods: {
            },



        };
    </script>
@endsection

