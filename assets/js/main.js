$( function() {

	// BEGIN UPSALE-UPDATE
	if ( document.getElementById( 'configUpsellForm' ) ) {
		(function(){

			var $form = $( '#configUpsellForm' );
			var $configButtons = $( '.upsell__config-btn' );
			var $deleteButton = $( '#deleteUpsellBtn' );

			$configButtons.on( 'click', function( e ) {
				var upsellId = $( this ).data( 'upsell-id' );

				$.ajax({
					method: 'get',
					url: globalData.ajaxUrl + '/upsell-data',
					dataType: 'json',
					data: {
						id: upsellId
					},
					success: function( data, status, xhr ) {
						$( '#upsellConfigTitle' ).text( 'Редактировать допродажу ' + data.name );
						$( '#upsellId2' ).val( data.id );
						$( '#upsellName2' ).val( data.name );
						$( '#upsellTitle2' ).val( data.title );
						$( '#upsellDesc2' ).val( data.description );
						$( '#upsellPrice2' ).val( data.price );
						$( '#upsellCurrency2' ).val( data.currency );
						$( '#upsellImg2' ).val( data.image ).trigger('change');
						$( '#upsellUrl2' ).val( data.url );
						$deleteButton.data( 'upsell-id', data.id );
					},
					error: function( xhr, status, error ) {
						new PNotify({
							title: 'Ошибка',
							text: error,
							type: 'error',
							styling: 'bootstrap3'
						});	
					}
				});

			} );

			$form.on( 'submit', function( e ) {
				e.preventDefault();

				var $configForm = $( this );

				$.ajax({
					method: 'get',
					url: globalData.ajaxUrl + '/upsell-update',
					dataType: 'json',
					data: $configForm.serialize(),
					success: function( data, status, xhr ) {
						if ( data.success ) {
							document.location.reload( true );
						} else {
							new PNotify({
								title: 'Ошибка',
								text: 'Допродажа по какой-то причине не был обновлена!',
								type: 'error',
								styling: 'bootstrap3'
							});	
						}
					},
					error: function( xhr, status, error ) {
						new PNotify({
							title: 'Ошибка',
							text: error,
							type: 'error',
							styling: 'bootstrap3'
						});	
					}
				});

			} );

			$deleteButton.on( 'click', function( e ) {
				e.preventDefault();
				var upsellId = $( this ).data( 'upsell-id' );

				$.ajax({
					method: 'get',
					url: globalData.ajaxUrl + '/upsell-delete',
					dataType: 'json',
					data: { id: upsellId },
					success: function( data, status, xhr ) {
						if ( data.success ) {
							document.location.reload( true );
						} else {
							new PNotify({
								title: 'Ошибка',
								text: 'Допродажа по какой-то причине не был удалена!',
								type: 'error',
								styling: 'bootstrap3'
							});	
						}
					},
					error: function( xhr, status, error ) {
						new PNotify({
							title: 'Ошибка',
							text: error,
							type: 'error',
							styling: 'bootstrap3'
						});	
					}
				});
			} );

		}());
	}
	// END UPSALE-UPDATE

	// BEGIN LAND-UPDATE
	if ( document.getElementById( 'landConfigForm' ) ) {
		(function(){

			var $form = $( '#landConfigForm' );
			var $configButtons = $( '.land__config-btn' );
			var upsellToggles = Array.prototype.slice.call( document.querySelectorAll( '.upsell__toggle' ) );
			var $deleteButton = $( '#deleteLandBtn' );

			upsellToggles.forEach( function( elem ) {
				var switchery = new Switchery( elem );

				$( elem ).on( 'change', switchery , function( e ) {
					var switcher = e.data;
					switcher.disable();
					
					var landId = $( this ).data( 'land-id' );
					var value = this.checked;
					var type = $( this ).data( 'upsell-type' );

					$.ajax({
						method: 'get',
						url: globalData.ajaxUrl + '/land-upsell-toggle',
						dataType: 'json',
						data: {
							id: landId,
							value: value,
							type: type
						},
						success: function( data, status, xhr ) {
							switcher.enable();

							if ( data.success ) {
								var text, type;
								if ( data.data === 'true' ) {
									text = 'Допродажа успешно включена';
									type = 'success';
								} else if ( data.data === 'false' ) {
									text = 'Допродажа успешно выключена';
									type = '';
								}

								new PNotify({
									title: 'Успешно обновлен!',
									text: text,
									type: type,
									styling: 'bootstrap3'
								});	
							} else {
								new PNotify({
									title: 'Ошибка',
									text: 'Лендинг по какой-то причине не был обновлен!',
									type: 'error',
									styling: 'bootstrap3'
								});	
							}
						},
						error: function( xhr, status, error ) {
							switcher.enable();
							new PNotify({
								title: 'Ошибка',
								text: error,
								type: 'error',
								styling: 'bootstrap3'
							});	
						}
					});
				} )
			});

			$configButtons.on( 'click', function( e ) {
				var landId = $( this ).data( 'land-id' );

				$.ajax({
					method: 'get',
					url: globalData.ajaxUrl + '/land-data',
					dataType: 'json',
					data: {
						id: landId
					},
					success: function( data, status, xhr ) {
						$( '#landConfigTitle' ).text( 'Редактировать ' + data.name );
						$( '#landId2' ).val( data.id );
						$( '#landName2' ).val( data.name );
						$( '#landUrl2' ).val( data.url );
						$( '#landUpsell_hit2' ).val( data.upsell_hit );
						$deleteButton.data( 'land-id', data.id );

						if ( Array.isArray( data.upsells ) ) {
							$( '#landUpsells2' ).val( data.upsells ).trigger('change.select2');
						} else {
							$( '#landUpsells2' ).val( '' ).trigger('change.select2');
						}
					},
					error: function( xhr, status, error ) {
						new PNotify({
							title: 'Ошибка',
							text: error,
							type: 'error',
							styling: 'bootstrap3'
						});	
					}
				});

			} );

			$form.on( 'submit', function( e ) {
				e.preventDefault();

				var $configForm = $( this );

				$.ajax({
					method: 'get',
					url: globalData.ajaxUrl + '/land-update',
					dataType: 'json',
					data: $configForm.serialize(),
					success: function( data, status, xhr ) {
						if ( data.success ) {
							document.location.reload( true );
						} else {
							new PNotify({
								title: 'Ошибка',
								text: 'Лендинг по какой-то причине не был обновлен!',
								type: 'error',
								styling: 'bootstrap3'
							});	
						}
					},
					error: function( xhr, status, error ) {
						new PNotify({
							title: 'Ошибка',
							text: error,
							type: 'error',
							styling: 'bootstrap3'
						});	
					}
				});

			} );

			$deleteButton.on( 'click', function( e ) {
				e.preventDefault();
				var landId = $( this ).data( 'land-id' );

				$.ajax({
					method: 'get',
					url: globalData.ajaxUrl + '/land-delete',
					dataType: 'json',
					data: { id: landId },
					success: function( data, status, xhr ) {
						if ( data.success ) {
							document.location.reload( true );
						} else {
							new PNotify({
								title: 'Ошибка',
								text: 'Лендинг по какой-то причине не был удален!',
								type: 'error',
								styling: 'bootstrap3'
							});	
						}
					},
					error: function( xhr, status, error ) {
						new PNotify({
							title: 'Ошибка',
							text: error,
							type: 'error',
							styling: 'bootstrap3'
						});	
					}
				});
			} );

		}());
	}
	// END LAND-UPDATE

	// BEGIN IMAGE_DELETE
	if ( document.getElementsByClassName( 'image__item' ).length > 0 ) {
		(function(){
			
			$( '.image__delete' ).on( 'click', function( e ) {
				e.preventDefault();
				var id = $( this ).data( 'image-id' );
				var name = $( this ).data( 'image-name' );

				$.ajax({
					method: 'get',
					url: globalData.ajaxUrl + '/image-delete',
					dataType: 'json',
					data: {
						id: id,
						name: name
					},
					success: function( data, status, xhr ) {
						if ( data.success ) {
							document.location.reload( true );
						} else {
							new PNotify({
								title: 'Ошибка',
								text: 'Файл по какой-то причине не был удален!',
								type: 'error',
								styling: 'bootstrap3'
							});	
						}
					},
					error: function( xhr, status, error ) {
						new PNotify({
							title: 'Ошибка',
							text: error,
							type: 'error',
							styling: 'bootstrap3'
						});	
					}
				});
				
			} )

		}());
	}
	// END IMAGE_DELETE

	// BEGIN LANDS-TABLE
	if ( document.getElementById( 'datatable-responsive' ) ) {
		(function(){

			$('#datatable-responsive').DataTable({
				"language": {
					"processing": "Подождите...",
					"search": "Поиск:",
					"lengthMenu": "Показать _MENU_ записей",
					"info": "Записи с _START_ до _END_ из _TOTAL_ записей",
					"infoEmpty": "Записи с 0 до 0 из 0 записей",
					"infoFiltered": "(отфильтровано из _MAX_ записей)",
					"infoPostFix": "",
					"loadingRecords": "Загрузка записей...",
					"zeroRecords": "Записи отсутствуют.",
					"emptyTable": "В таблице отсутствуют данные",
					"paginate": {
						"first": "Первая",
						"previous": "Предыдущая",
						"next": "Следующая",
						"last": "Последняя"
					},
					"aria": {
						"sortAscending": ": активировать для сортировки столбца по возрастанию",
						"sortDescending": ": активировать для сортировки столбца по убыванию"
					}
				}
			});

		}());
	}
	// END LANDS-TABLE

	// BEGIN UPSELLS-TABLE
	if ( document.getElementById( 'datatable-upsells' ) ) {
		(function(){

			$('#datatable-upsells').DataTable({
				"language": {
					"processing": "Подождите...",
					"search": "Поиск:",
					"lengthMenu": "Показать _MENU_ записей",
					"info": "Записи с _START_ до _END_ из _TOTAL_ записей",
					"infoEmpty": "Записи с 0 до 0 из 0 записей",
					"infoFiltered": "(отфильтровано из _MAX_ записей)",
					"infoPostFix": "",
					"loadingRecords": "Загрузка записей...",
					"zeroRecords": "Записи отсутствуют.",
					"emptyTable": "В таблице отсутствуют данные",
					"paginate": {
						"first": "Первая",
						"previous": "Предыдущая",
						"next": "Следующая",
						"last": "Последняя"
					},
					"aria": {
						"sortAscending": ": активировать для сортировки столбца по возрастанию",
						"sortDescending": ": активировать для сортировки столбца по убыванию"
					}
				}
			});

		}());
	}
	// END UPSELLS-TABLE

	// BEGIN SELECT-LAND-UPSELLS
	if ( document.getElementById( 'landUpsells2' ) ) {
		(function(){

        $("#landUpsells2").select2({
          placeholder: "Допродажи",
          allowClear: true,
          dropdownCssClass: "increasedzindexclass",
          width: 'resolve'
        });

		}());
	}
	// END SELECT-LAND-UPSELLS

} );