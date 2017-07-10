$( function() {

	// BEGIN PRODUCT-UPDATE
	if ( document.getElementById( 'productConfigForm' ) ) {
		(function(){

			var $form = $( '#productConfigForm' );
			var $configButtons = $( '.products__config-btn' );
			var $deleteButton = $( '#deleteProductBtn' );

			$configButtons.on( 'click', function( e ) {
				var productId = $( this ).data( 'product-id' );

				$.ajax({
					method: 'get',
					url: globalData.ajaxUrl + '/product-data',
					dataType: 'json',
					data: {
						id: productId
					},
					success: function( data, status, xhr ) {
						$( '#productConfigTitle' ).text( 'Редактировать ' + data.name );
						$( '#productConfigId' ).val( data.id );
						$( '#productName2' ).val( data.name );
						$( '#productId2' ).val( data.crm_id );

						$deleteButton.data( 'product-id', data.id );
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
					url: globalData.ajaxUrl + '/product-update',
					dataType: 'json',
					data: $configForm.serialize(),
					success: function( data, status, xhr ) {
						if ( data.success ) {
							document.location.reload( true );
						} else {
							new PNotify({
								title: 'Ошибка',
								text: 'Товар по какой-то причине не был обновлен!',
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
				var productId = $( this ).data( 'product-id' );

				$.ajax({
					method: 'get',
					url: globalData.ajaxUrl + '/product-delete',
					dataType: 'json',
					data: { id: productId },
					success: function( data, status, xhr ) {
						if ( data.success ) {
							document.location.reload( true );
						} else {
							new PNotify({
								title: 'Ошибка',
								text: 'Товар по какой-то причине не был удален!',
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
	// END PRODUCT-UPDATE

	// BEGIN LAND-DATA-UPDATE
	if ( document.getElementById( 'landDataConfigForm' ) ) {
		(function(){

			var $form = $( '#landDataConfigForm' );
			var $configButtons = $( '.land-data__config-btn' );
			var $deleteButton = $( '#deleteLandDataBtn' );

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
						var titleText =  'Редактировать ' + data.name;
						if ( data.layer === 'true' ) {
							titleText += ' <span class="label label-info">Прокладка</span>';
						}

						$( '#landConfigTitle' ).html( titleText );
						$( '#landDataId' ).val( data.id );
						$( '#landDataName' ).val( data.name );
						$( '#landDataUrl' ).val( data.url );
						$( '#landDataProduct' ).val( data.product );
						$( '#landDataPrice1' ).val( data.price1 );
						$( '#landDataPrice2' ).val( data.price2 );
						$( '#landDataPrice3' ).val( data.price3 );
						$( '#landDataPrice4' ).val( data.price4 );
						$( '#landDataPrice5' ).val( data.price5 );
						$( '#landDataPrice6' ).val( data.price6 );
						$( '#landDataPrice7' ).val( data.price7 );
						$( '#landDataPrice8' ).val( data.price8 );
						$( '#landDataPrice9' ).val( data.price9 );
						$( '#landDataPrice10' ).val( data.price10 );
						$( '#landDataDiscount' ).val( data.discount );
						$( '#landDataCurrency' ).val( data.currency );
						$deleteButton.data( 'land-id', data.id );
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
	// END LAND-DATA-UPDATE

	// BEGIN LAND-METRIC-UPDATE
	if ( document.getElementById( 'metricLandForm' ) ) {
		(function(){

			var $form = $( '#metricLandForm' );
			var $configButtons = $( '.land-data__metric-btn' );

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
						$( '#landMetricTitle' ).text( 'Редактировать метрики ' + data.name );
						$( '#metricLandId' ).val( data.id );
						$( '#metricIndexHead' ).val( data.metric_head_index );
						$( '#metricIndexBody' ).val( data.metric_body_index );
						$( '#metricThanksHead' ).val( data.metric_head_thanks );
						$( '#metricThanksBody' ).val( data.metric_body_thanks );
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

		}());
	}
	// END LAND-METRIC-UPDATE

	// BEGIN LAND-SCRIPT-UPDATE
	if ( document.getElementById( 'scriptLandForm' ) ) {
		(function(){

			var $form = $( '#scriptLandForm' );
			var $configButtons = $( '.land-data__script-btn' );
			var checkbox = document.getElementById( 'scriptActiveCheckbox' );
			var switchery = new Switchery( checkbox );

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
						$( '#landScriptTitle' ).text( 'Редактировать скрипт ' + data.name );
						$( '#scriptLandId' ).val( data.id );
						if ( data.script_active === 'on' && !checkbox.checked ||
							data.script_active !== 'on' && checkbox.checked ) {
							$( checkbox ).trigger( 'click' );
						} 
						$( '#scriptCountry' ).val( data.script_country );
						$( '#scriptSex' ).val( data.script_sex );
						$( '#scriptWindows' ).val( data.script_windows );
						$( '#scriptItems' ).val( data.script_items );
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
					url: globalData.ajaxUrl + '/land-update-script',
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

		}());
	}
	// END LAND-SCRIPT-UPDATE

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
						$( '#upsellStream2' ).val( data.stream );
						$( '#upsellLand2' ).val( data.land ).trigger('change.select2');
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

	// BEGIN LAND-UPSELL-UPDATE
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
						var titleText =  'Редактировать ' + data.name;
						if ( data.layer === 'true' ) {
							titleText += ' <span class="label label-info">Прокладка</span>';
						}
						$( '#landConfigTitle' ).html( titleText );
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
					url: globalData.ajaxUrl + '/land-update-upsells',
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
	// END LAND-UPSELL-UPDATE

	// BEGIN TEST-UPDATE
	if ( document.getElementById( 'testConfigForm' ) ) {
		(function(){

			var $form = $( '#testConfigForm' );
			var $configButtons = $( '.test__config-btn' );
			var testToggles = Array.prototype.slice.call( document.querySelectorAll( '.test__toggle' ) );
			var $deleteButton = $( '#deleteTestBtn' );

			testToggles.forEach( function( elem ) {
				var switchery = new Switchery( elem );

				$( elem ).on( 'change', switchery , function( e ) {
					var switcher = e.data;
					switcher.disable();
					
					var landId = $( this ).data( 'land-id' );
					var value = this.checked;

					$.ajax({
						method: 'get',
						url: globalData.ajaxUrl + '/land-test-toggle',
						dataType: 'json',
						data: {
							id: landId,
							value: value
						},
						success: function( data, status, xhr ) {
							switcher.enable();

							if ( data.success ) {
								var text, type;
								if ( data.data === 'true' ) {
									text = 'Тест успешно включен';
									type = 'success';
								} else if ( data.data === 'false' ) {
									text = 'Тест успешно выключен';
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
									text: 'Тест по какой-то причине не был обновлен!',
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
						$( '#landConfigTitle' ).text( 'Редактировать тест ' + data.name );
						$( '#landId3' ).val( data.id );
						$deleteButton.data( 'land-id', data.id );

						if ( Array.isArray( data.redirections ) ) {
							$( '#testRedirects2' ).val( data.redirections ).trigger('change.select2');
						} else {
							$( '#testRedirects2' ).val( '' ).trigger('change.select2');
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
					url: globalData.ajaxUrl + '/test-update',
					dataType: 'json',
					data: $configForm.serialize(),
					success: function( data, status, xhr ) {
						if ( data.success ) {
							document.location.reload( true );
						} else {
							new PNotify({
								title: 'Ошибка',
								text: 'Тест по какой-то причине не был обновлен!',
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

			});

			$deleteButton.on( 'click', function( e ) {
				e.preventDefault();
				var landId = $( this ).data( 'land-id' );

				$.ajax({
					method: 'get',
					url: globalData.ajaxUrl + '/test-update',
					dataType: 'json',
					data: { entry: landId },
					success: function( data, status, xhr ) {
						if ( data.success ) {
							document.location.reload( true );
						} else {
							new PNotify({
								title: 'Ошибка',
								text: 'Тест по какой-то причине не был удален!',
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
	// END TEST-UPDATE

	// BEGIN LAYER-UPDATE
	if ( document.getElementById( 'layerConfigForm' ) ) {
		(function(){

			var $form = $( '#layerConfigForm' );
			var $configButtons = $( '.layer__config-btn' );
			var $deleteButton = $( '#deleteLayerBtn' );

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
						$( '#layerConfigTitle' ).text( 'Редактировать прокладку ' + data.name );
						$( '#layerId2' ).val( data.id );
						$( '#layerTarget2' ).val( data.layer_target ).trigger('change.select2');
						$deleteButton.data( 'land-id', data.id );						
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
								text: 'Прокладка по какой-то причине не была обновлена!',
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

			});

			$deleteButton.on( 'click', function( e ) {
				e.preventDefault();
				var landId = $( this ).data( 'land-id' );

				$.ajax({
					method: 'get',
					url: globalData.ajaxUrl + '/layer-delete',
					dataType: 'json',
					data: { id: landId },
					success: function( data, status, xhr ) {
						if ( data.success ) {
							document.location.reload( true );
						} else {
							new PNotify({
								title: 'Ошибка',
								text: 'Прокладка по какой-то причине не была удалена!',
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
	// END LAYER-UPDATE

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

	// BEGIN TABLES
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
	// END TABLES

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

	// BEGIN SELECT-LANDINGS
	if ( document.getElementsByClassName( 'select2_group' ).length > 0 ) {
		(function(){

        	$( ".select2_group" ).select2({
        		dropdownCssClass: "increasedzindexclass",
          		width: 'resolve'
        	});

		}());
	}
	// END SELECT-LANDINGS

	// BEGIN SELECT-TEST-REDIRECTS
	if ( document.getElementById( 'testRedirects' ) ) {
		(function(){

        $("#testRedirects").select2({
          placeholder: "Направления",
          // allowClear: true,
          dropdownCssClass: "increasedzindexclass",
          width: 'resolve'
        });

        $("#testRedirects2").select2({
          placeholder: "Направления",
          // allowClear: true,
          dropdownCssClass: "increasedzindexclass",
          width: 'resolve'
        });

		}());
	}
	// END SELECT-TEST-REDIRECTS

	
} );