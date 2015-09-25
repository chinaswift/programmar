<div class="modal fade" id="paymentModal">
  <div class="modal-dialog" role="document">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      <span class="sr-only">Close</span>
    </button>
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">You can send this developer a drink!</h4>
      </div>
      <form name="cardForm" ng-show="article.allow_drink > 0" novalidate ng-cloak ng-submit="handlePayment(article.owner_id);">
        <div class="modal-body">
          <div class="row" style="max-width: 345px; margin: 0 auto;">
            <div class="col-xs-12">
              <input class="input--primary" placeholder="Enter your card number..." size="20" type="text" ng-model="drinkPayment.number" data-stripe="number">
            </div>
            <div class="col-xs-3">
              <input  class="input--primary" type="text" placeholder="04" class="card-month" data-stripe="exp-month" ng-model="drinkPayment.month">
            </div>
            <div class="col-xs-3">
              <input  class="input--primary" type="text" placeholder="19" class="card-year" data-stripe="exp-year" ng-model="drinkPayment.year">
            </div>
            <div class="col-xs-6">
              <input  class="input--primary" placeholder="CVV" type="text" size="4" data-stripe="cvc" ng-model="drinkPayment.cvc" class="card-cvv other" id="card-cvv">
            </div>
          </div>
        </div>
      <div class="modal-footer">
        <button class="btn btn-github" id="payment-btn" type="submit" ng-disabled="stripeSending">Pay now</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->