var bin = angular.module("bien", ["ngCkeditor"]);

bin.controller('inputFilesController', function($scope){
	$scope.choices = [{id: 'choice1'}];
  
	$scope.addNewInput = function() {
		var newItemNo = $scope.choices.length+1;
		$scope.choices.push({'id':'choice'+newItemNo});
		console.log('newItemNo'+newItemNo);
	};
    
	$scope.removeInput = function() {
		var lastItem = $scope.choices.length-1;
		$scope.choices.splice(lastItem);
		console.log(lastItem);
	};

	$scope.addCoices = function(text){
		$scope.choices.push(text);
	};
});

bin.directive('ckEditor', function () {
  return {
    require: '?ngModel',
    link: function (scope, elm, attr, ngModel) {
      var ck = CKEDITOR.replace(elm[0]);
      if (!ngModel) return;
      ck.on('instanceReady', function () {
        ck.setData(ngModel.$viewValue);
      });
      function updateModel() {
        scope.$apply(function () {
          ngModel.$setViewValue(ck.getData());
        });
      }
      ck.on('change', updateModel);
      ck.on('key', updateModel);
      ck.on('dataReady', updateModel);

      ngModel.$render = function (value) {
        ck.setData(ngModel.$viewValue);
      };
    }
  };
});

bin.controller('guestBook', function($scope, $http, $timeout){
	$scope.guests = {};
	$scope.link;
	$scope.name;
	$scope.email;
	$scope.message;
	$scope.postRslt;

	$scope.page = 1;
	$scope.numPage;
	$scope.lastPage;
	$scope.noRow = 1;

	$scope.start_page = 1 * $scope.page - 2;
	$scope.end_page = 1 * $scope.page + 4;

	$scope.guest_list = function(page=null){
      	console.log('page '+page);
		if (page!=null){
			$scope.link = '../api/guest_book/all/page/'+page;
		}else{
			$scope.link = '../api/guest_book/all/';
		}
		$http.get($scope.link).then(function(response){
			$scope.guests = response.data;
      	});
      	console.log($scope.guests);
	}

	$scope.guest_add = function()
	{
		var dataObj = {
			'name': $scope.name,
			'email': $scope.email,
			'message': $scope.message
		}
		$http.post('../api/guest_book/add', dataObj).then(function(response){
			$scope.postRslt = dataObj;
      	});
	}

	$scope.publish = function(id,publish){
		$http.get('../api/guest_book/publish/id/'+id+'/publish/'+publish).then(function(response){
			$scope.postRslt = dataObj;
      	});
      	$timeout(function(){
      		$scope.guest_list($scope.page);
      	}, 200);
	}

	$scope.get_last_page = function(){
		$http.get('../api/guest_book/num_row_all').then(function(response){
			$scope.lastPage = response.data;
      	});
	}

	$scope.buatPage = function(start_page, end_page){
		$scope.get_last_page();
		$timeout(function(){
			if (start_page < 1){
				$scope.start_page = 1;
			}

			console.log("a"+$scope.lastPage+"#"+end_page);
			if (end_page > parseInt($scope.lastPage)){
				console.log("b"+$scope.lastPage);
				$scope.end_page = $scope.lastPage;
			}

			var tp = [];
			for(var i=$scope.start_page; i<=$scope.end_page; i++){
				tp.push(i);
			}
			$scope.numPage = tp;
		}, 300);
	};
	$scope.buatPage($scope.start_page, $scope.end_page)

	$scope.no_page = function(noPg){
		$scope.page = noPg;
		console.log(noPg);
		$scope.start_page = 1 * $scope.page - 2;
		$scope.end_page = 1 * $scope.page + 4;
		$scope.buatPage($scope.start_page, $scope.end_page);
		$scope.guest_list(noPg);
	};
});

