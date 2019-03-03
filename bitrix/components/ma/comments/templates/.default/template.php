<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$randId = rand();
if (!empty($arResult['MESSAGE'])) {
	$SHOW_FORM = true;
}

//dump($arResult['ITEMS']);
?>
<div class="b-comments" id="comments-app-<?=$randId?>">
	<div class="b-comments_show-form" style="<?=$SHOW_FORM ? 'display: none' : ''?>">
		<a href="#" class="g-button">Оставить отзыв</a>
	</div>
	<div class="b-comments-form" style="<?=$SHOW_FORM ? '' : 'display: none'?>">
		<?php if (!empty($arResult['MESSAGE']['GOOD'])): ?>
			<div class="b-comments-form_mess mess-good"><?=$arResult['MESSAGE']['GOOD']?></div>
		<?php else: ?>
			<?php if (!empty($arResult['MESSAGE']['ERROR'])): ?>
				<div class="b-comments-form_mess mess-bad"><?=$arResult['MESSAGE']['ERROR']?></div>
			<?php endif ?>
			<form action="" method="POST">
				<div id="reply-item" class="b-comments-form_item b-comments-form_text" style="display:none;">
					<label for="REPLY_COMMENT_ID">Ответ на комментарий #</label>
					<input 
						readonly="readonly"
						id="REPLY_COMMENT_ID"
						type="hidden"
						name="REPLY_COMMENT_ID"
						placeholder="Ответ на комментарий #"
						value="<?=$_REQUEST['REPLY_COMMENT_ID']?>">
				</div>
				<div class="b-comments-form_item b-comments-form_text">
					<label for="COMMENT_NAME">Ваше имя</label>
					<input id="COMMENT_NAME" type="text" name="COMMENT_NAME" placeholder="Ваше имя" value="<?=html_entity_decode($_REQUEST['COMMENT_NAME'] ? $_REQUEST['COMMENT_NAME'] : $arResult['CUR_USER']['NAME'])?>">
				</div>
				<div class="b-comments-form_item b-comments-form_text">
					<label for="COMMENT_EMAIL">E-mail</label>
					<input id="COMMENT_EMAIL" type="text" name="COMMENT_EMAIL" placeholder="E-mail" value="<?=html_entity_decode($_REQUEST['COMMENT_EMAIL'] ? $_REQUEST['COMMENT_EMAIL'] : $arResult['CUR_USER']['EMAIL'])?>">
				</div>
				<div class="b-comments-form_item b-comments-form_text no-mrg">
					<label for="COMMENT_CITY">Город</label>
					<input id="COMMENT_CITY" type="text" name="COMMENT_CITY" placeholder="Город" value="<?=html_entity_decode($_REQUEST['COMMENT_CITY'] ? $_REQUEST['COMMENT_CITY'] : $arResult['CUR_USER']['PERSONAL_CITY'])?>">
				</div>
				<div class="g-clean"></div>
				<div class="b-comments-form_item b-comments-form_textarea">
					<label for="COMMENT_TEXT">Ваш комментарий</label>
					<textarea name="COMMENT_TEXT" id="COMMENT_TEXT" placeholder="Комментарий"><?=html_entity_decode($_REQUEST['COMMENT_TEXT'])?></textarea>
				</div>
				<?php if (!empty($arResult['CAPTCHA_CODE'])): ?>
					<div class="b-comments-form_item b-comments-form_captcha">
						<label for="COMMENT_CAPTCHA">Защита от роботов</label>
						<input type="hidden" name="captcha_sid" value="<?=$arResult['CAPTCHA_CODE']?>" />
						<img src="/bitrix/tools/captcha.php?captcha_code=<?=$arResult['CAPTCHA_CODE']?>" width="180" height="40" alt="CAPTCHA" />
						<input id="COMMENT_CAPTCHA" type="text" name="captcha_word" placeholder="Введите символы">
					</div>
				<?php endif ?>
				<div class="b-comments-form_item b-comments-form_action">
					<input class="g-button" name="submit" type="submit" value="Отправить">

				</div>
			</form>
		<?php endif ?>
	</div>

	<div class="b-comments-list">
		<?php foreach ($arResult['ITEMS'] as $key => $arComment): ?>
			<?php
				$classString = '';
				if (!empty($arComment['CHILD_ITEMS'])) {
					$classString .= ' has-child';
				}
				if ($arComment['MARK'] == "Y") {
					$classString .= ' marked';	
				}
			?>
			<div
				id="comment-id-<?=$arComment['ID']?>"
				class="b-comments-list_item <?=$classString?>">
				<?php if (false): ?>
					<a
						href="#"
						data-id="<?=$arComment['ID']?>"
						data-action="reply"
						class="b-comments-list_item-num comment-action">#<?=$arComment['ID']?></a>
				<?php endif ?>
				<div class="b-comments-list_item-title">
					<span class="b-comments-list_item-name"><?=html_entity_decode($arComment['USER_NAME'])?>,</span>
					<?php if ($arComment['USER_CITY']): ?>
						<span class="b-comments-list_item-city"><?=html_entity_decode($arComment['USER_CITY'])?><?=html_entity_decode($arComment['DATE_CREATED']) ? ',' : ''?></span>
					<?php endif ?>
					<?php if ($arComment['DATE_CREATED']): ?>
						<span class="b-comments-list_item-date"><?=html_entity_decode($arComment['DATE_CREATED'])?></span>
					<?php endif ?>
				</div>
				<div class="b-comments-list_item-text">
					<?=html_entity_decode($arComment['COMMENT_TEXT']);?>
				</div>
				<div class="b-comments-list_item-actions">
					<a
						href="#"
						data-id="<?=$arComment['ID']?>"
						data-action="reply"
						class="comment-action">Ответить</a>
				</div>
				<?php if (!empty($arComment['CHILD_ITEMS'])): ?>
					<?php foreach ($arComment['CHILD_ITEMS'] as $arChildComment): ?>
						<?php
							$classString = '';
							if ($arChildComment['MARK'] == "Y") {
								$classString .= ' marked';	
							}
						?>
						<div class="b-comments-list_item child-item <?=$classString?>">
							<?php if (false): ?>
								<a
									href="#"
									data-id="<?=$arChildComment['ID']?>"
									data-action="reply"
									class="b-comments-list_item-num comment-action">#<?=$arChildComment['ID']?></a>
							<?php endif ?>
							<div class="b-comments-list_item-title">
								<span class="b-comments-list_item-name"><?=html_entity_decode($arChildComment['USER_NAME'])?>,</span>
								<?php if ($arChildComment['USER_CITY']): ?>
									<span class="b-comments-list_item-city"><?=html_entity_decode($arChildComment['USER_CITY'])?><?=html_entity_decode($arChildComment['DATE_CREATED']) ? ',' : ''?></span>
								<?php endif ?>
								<?php if ($arChildComment['DATE_CREATED']): ?>
									<span class="b-comments-list_item-date"><?=html_entity_decode($arChildComment['DATE_CREATED'])?></span>
								<?php endif ?>
							</div>
							<div class="b-comments-list_item-text">
								<?=html_entity_decode($arChildComment['COMMENT_TEXT']);?>
							</div>
							<?php if (false): ?>
								<div class="b-comments-list_item-actions">
									<a
										href="#"
										data-id="<?=$arChildComment['ID']?>"
										data-action="reply"
										class="comment-action">Ответить</a>
								</div>
							<?php endif ?>
						</div>
					<?php endforeach ?>
					
				<?php endif ?>
				<div class="b-comments-list_reply-holder" style="display:none;"></div>
			</div>
		<?php endforeach ?>
	</div>
</div>
<div class="g-clean"></div>
<script>
	$(function() {
		var commentsApp = $('#comments-app-<?=$randId?>');
		var showBtnContainer = $(commentsApp).find('.b-comments_show-form'),
			formContainer = $(commentsApp).find('.b-comments-form'),
			listContainer = $(commentsApp).find('.b-comments-list');

		$(showBtnContainer).find('a').on('click', function(event) {
			event.preventDefault();
			formVisible('show');
		});

		$(listContainer).find('a.comment-action').on('click', function(event) {
			event.preventDefault();
			var commentId = $(this).attr('data-id'),
				commentAction = $(this).attr('data-action');
			if (commentAction == 'reply') {
				replyAction(commentId);
			}
		});

		function formVisible(showType) {
			if (showType == 'show') {
				$(formContainer).slideDown('slow');
				$(showBtnContainer).hide();
			}
		}
		function replyAction(commentId) {
			var replyContainer = $(commentsApp).find('#comment-id-'+commentId+' .b-comments-list_reply-holder');
			//var formHtml = $(formContainer).html();
			//$(replyContainer).html(formHtml);
			
			var ajaxUrl = '<?=$templateFolder?>/form.php';
			$.ajax({
				url: ajaxUrl,
				success: function(data) {
					if (data.length) {
						$(replyContainer).html(data);
						$(replyContainer).slideDown('slow');
						$(replyContainer).find('#REPLY_COMMENT_ID').val(commentId);

						//Using google reCaptcha
						try {
							
							var elements = $(replyContainer).find('.g-recaptcha');
							for (var i = 0; i < elements.length; i++) {
							  grecaptcha.render(elements[i], {
							      'sitekey' : elements[i].getAttribute("data-sitekey"),
							      'theme' : elements[i].getAttribute("data-theme")
							    });

							}
						} catch (e) {
							console.log(e);
						}
					}
				}
			});




			// $(formContainer).find('#reply-item').show();
			// $(formContainer).find('#REPLY_COMMENT_ID').val(commentId);
			// $(formContainer).focus();
			// $('html, body').animate({
			// 	scrollTop: $(formContainer).offset().top-100
			// }, 400);
		}
	});
</script>