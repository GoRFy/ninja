

<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <div class="panel panel-primary2">
            <div class="panel-heading">My Inbox</div>
            <div class="panel-body">
                <div class="my-inbox">
                    <!-- DISCUSSION LIST -->
                    <div class="discussion-list">
                        <div class="new-discussion">
                            new discussion
                            <?php $this->createForm($form, $formErrors) ?>
                        </div>
                        <div class="discussion-list js-discussion-list">
                            discussion list
                            <ul></ul>
                        </div>
                    </div>
                    <!-- CHAT BODY -->
                    <div class="chat-body">
                        chat box
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
