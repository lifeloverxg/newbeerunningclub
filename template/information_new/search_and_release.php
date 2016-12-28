<!-- Search & Release -->
 <div class="search-and-release">
    <div class="search-article">
        <span>
            <select>
                <?php foreach ($article_catalog_list as $catalog_id => $catalog_name) { ?>
                    <option value="<?php echo $catalog_id; ?>"><?php echo $catalog_name; ?></option>
                    <?php } ?>
            </select>
            <input type="text" placeholder="暂时无法使用"></input>
            <button type="submit"> 搜索</button>
        </span>
    </div>
    <?php if (isset($_SESSION['auth'])) { ?> 
    <div class="release-article">
        <button type="button" onclick= "show_article_panel()"> 发表文章</button>
    </div>
    <?php }
    ?>
 </div>  

