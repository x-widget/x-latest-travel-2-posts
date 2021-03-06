<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

widget_css();

$icon_url = widget_data_url( $widget_config['code'], 'icon' );

$file_headers = @get_headers($icon_url);

if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
    $icon_url = x::url()."/widget/".$widget_config['name']."/img/2paperswhite.png";
}

if( $widget_config['forum1'] ) $_bo_table = $widget_config['forum1'];
else $_bo_table = $widget_config['default_forum_id'];

if ( empty($_bo_table) ) jsAlert('Error: empty $_bo_table ? on widget :' . $widget_config['name']);

if( $widget_config['no'] ) $limit = $widget_config['no'];
else $limit = 14;

$list = g::posts( array(
			"bo_table" 	=>	$_bo_table,
			"limit"		=>	$limit,
			"select"	=>	"idx,domain,bo_table,wr_id,wr_parent,wr_is_comment,wr_comment,ca_name,wr_datetime,wr_hit,wr_good,wr_nogood,wr_name,mb_id,wr_subject,wr_content"
				)
		);
		
$title = $widget_config['title'];
	if ( empty( $title ) ) {
		$cfg = g::config( $_bo_table, 'bo_subject' );
		$title = cut_str( $cfg['bo_subject'],10,"...");
	}

	if ( empty($title) ) {
		$title = "No title";
	}

?>
<div class="travel-2-posts2" >
		<div class='title'>			
			<div class='label'>
				<a href='<?=G5_BBS_URL?>/board.php?bo_table=<?=$_bo_table?>'><?=cut_str($title,15,'...')?></a>
			</div>
			<img src="<?=x::url()?>/widget/<?=$widget_config['name']?>/img/my-posts.png">			
			<div class='posts-more'><a href="<?=g::url()?>/bbs/board.php?bo_table=<?=$_bo_table?>" >자세히</a></div>
		</div>
	<div class='travel-2-posts-items'>
		<? if( $list ) { ?>
		<?php
			$i = 1;
			$no_of_posts = count($list);
			foreach ( $list as $li ) {
				$subject = $li['subject'];
				$url = $li['url'];
				$no_comment = '';
				if ( !$comment_count = strip_tags($li['comment_cnt']) ) {
					$comment_count = 0;
					$no_comment = 'no-comment';
				}
				
				if( $i == $no_of_posts ) $no_margin = 'no-margin';
				else $no_margin = null;
				
		?>		
			<div class = 'latest-items <?=$no_margin?>'>				
				<div class='item-subject'>
					<img src='<?=x::url()?>/widget/<?=$widget_config['name']?>/img/square-icon.png'>
					<a href='<?=$url?>' class='content-community-3'><?=$subject?></a>
				</div>				
				<div class='no-of-comments <?=$no_comment?>'>[<?=$comment_count?>]</div>				
				<div style='clear:both'></div>
			</div>			
				<?$i++;?>
		<?}?>
		<? }
			else {?>
			<div class = 'latest-items'>
				<div class='item-subject'><img src='<?=x::url()?>/widget/<?=$widget_config['name']?>/img/square-icon.png'><a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=5'>사이트 만들기 안내</a></div>
				<div style='clear:both'></div>
			</div>
			<div class = 'latest-items'>
				<div class='item-subject'><img src='<?=x::url()?>/widget/<?=$widget_config['name']?>/img/square-icon.png'><a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=4'>블로그 만들기</a></div>
				<div style='clear:both'></div>
			</div>
			<div class = 'latest-items'>
				<div class='item-subject'><img src='<?=x::url()?>/widget/<?=$widget_config['name']?>/img/square-icon.png'><a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=3'>커뮤니타 사이트 만들기</a></div>
				<div style='clear:both'></div>
			</div>
			<div class = 'latest-items'>
				<div class='item-subject'><img src='<?=x::url()?>/widget/<?=$widget_config['name']?>/img/square-icon.png'><a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=2' style='color: #cc4235; font-weight: bold;'>여행사 사이트 만들기</a></div>
				<div style='clear:both'></div>
			</div>
			<div class = 'latest-items'>
				<div class='item-subject'><img src='<?=x::url()?>/widget/<?=$widget_config['name']?>/img/square-icon.png'><a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=1'>(모바일)홈페이지, 스마트폰 앱</a></div>
				<div style='clear:both'></div>
			</div>
			<?}?>
	</div>
</div>
