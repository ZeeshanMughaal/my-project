<div class="post">
	<div class="title">
		<?php echo CHtml::link(CHtml::encode($data->title), $data->url); ?>
	</div>
	<div class="author">
		posted by <?php echo $data->author->username . ' on ' . date('F j, Y',$data->create_time); ?>
	</div>
	<div class="content">
		<?php
			$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			echo $data->content;
			$this->endWidget();
		?>
	</div>
	<div class="nav">
		<b>Tags:</b>
		<?php echo implode(', ', $data->tagLinks); ?>
		<br/>
		<!-- <a href="#"  id="LikedPostElement<?php echo $data->id;?>" onclick="LikedPost(<?php echo $data->id;?>)"><i class="fa-solid fa-heart"></i></a> | -->
		<?php
// Use the helper function to determine if the post is liked
$isLiked = Post::isPostLiked($data->id);
?>

<a href="#" id="LikedPostElement<?php echo $data->id; ?>" 
   <?php if ($isLiked) echo "style='color:red;'"; ?>
   onclick="LikedPost(<?php echo $data->id; ?>)">
   <i class="fa-solid fa-heart"></i>
</a>
		Last updated on <?php echo date('F j, Y',$data->update_time); ?>
	</div>
</div>
<script>

	function LikedPost(PostID){
		$.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl("post/LikePost"); ?>',
            data: { PostID: PostID },
            success: function(response) {
				var element = $("#LikedPostElement" + PostID);
					if (element.length) {
						element.css({'color': 'red'});
						console.log('Color changed to red for element:', element);
					}
            },
            error: function() {
                $('#email-exists-message').text('An error occurred while checking the email.');
            }
        });
	}
</script>