/**
 * SmartCenter - Drawer do carrinho, filtros, comportamento geral
 */
(function ($) {
	'use strict';

	var $drawer = $('#sc-cart-drawer');
	var $overlay = $('#sc-cart-overlay');

	function openCartDrawer() {
		$drawer.addClass('is-open').attr('aria-hidden', 'false');
		$overlay.addClass('is-open');
		$('body').css('overflow', 'hidden');
	}

	function closeCartDrawer() {
		$drawer.removeClass('is-open').attr('aria-hidden', 'true');
		$overlay.removeClass('is-open');
		$('body').css('overflow', '');
	}

	// Abrir drawer ao clicar no ícone da sacola
	$(document).on('click', '.sc-cart-trigger', function (e) {
		e.preventDefault();
		openCartDrawer();
	});

	// Fechar drawer
	$(document).on('click', '.sc-drawer-close, .sc-cart-drawer-overlay', function () {
		closeCartDrawer();
	});

	// Fechar com Escape
	$(document).on('keydown', function (e) {
		if (e.key === 'Escape' && $drawer.hasClass('is-open')) {
			closeCartDrawer();
		}
	});

	// Filtro por marca e ordenação na home (recarrega a página com query string)
	$('#sc-filter-brand').on('change', function () {
		var val = $(this).val();
		var url = new URL(window.location.href);
		if (val) {
			url.searchParams.set('filter_marca', val);
		} else {
			url.searchParams.delete('filter_marca');
		}
		url.searchParams.delete('paged');
		window.location.href = url.toString();
	});

	$('#sc-orderby').on('change', function () {
		var val = $(this).val();
		var url = new URL(window.location.href);
		if (val && val !== 'menu_order') {
			url.searchParams.set('orderby', val);
		} else {
			url.searchParams.delete('orderby');
		}
		url.searchParams.delete('paged');
		window.location.href = url.toString();
	});

	// Single product: trocar imagem principal ao clicar na miniatura
	$(document).on('click', '.sc-thumbnails img', function () {
		var src = $(this).data('full') || $(this).attr('src');
		$(this).closest('.sc-single-product').find('.sc-main-image img').attr('src', src);
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
	});

	// Atualizar drawer quando o carrinho for atualizado via AJAX (WooCommerce)
	$(document.body).on('added_to_cart removed_from_cart', function () {
		if ($drawer.hasClass('is-open')) {
			$.post((window.smartcenter_i18n || {}).ajax_url || '/wp-admin/admin-ajax.php', {
				action: 'smartcenter_refresh_mini_cart'
			}, function (res) {
				var html = res && res.data && res.data.html ? res.data.html : res;
				$drawer.find('.sc-drawer-body').html(html);
			});
		}
	});

})(jQuery);
