<div class="tab-pane mt-3 fade " id="referral" role="tabpanel" aria-labelledby="referral-tab">
    <div class="row">
        <div class="col-12 col-md-6">
            <form action="/admin/settings/main" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="page" value="financial">
                <input type="hidden" name="name" value="referral">


              
                <div class="empty-state mx-auto d-block"  data-width="900" >
                    <img class="img-fluid col-md-6" src="/assets/default/img/plugin.svg" alt="image">
                    <h3 class="mt-3">This is a paid plugin!</h3>
                    <h5 class="lead">
                        You can purchase it by <strong><a href="https://codecanyon.net/item/universal-plugins-bundle-for-rocket-lms/33297004">this link</a></strong> on Codecanyon.
                    </h5>    
                  </div>


            </form>
        </div>
    </div>
</div>
