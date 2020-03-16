<!DOCTYPE html>
<html>
<head>
	<?php require_once('../include/admin_head.inc.php'); ?>
	<title><?php echo LA_USERS." - {$OJ_NAME}";?></title>

</head>
<body>
	<?php require('./pages/components/offcanvas.php');?>
	<div class="container" id="mainContent">
		<div class="page-header">
			<h1><?php echo LA_USERS;?> <small>User List</small></h1>
		</div>
		<p class="lead">
			<?php echo LA_USER_HELP;?>
		</p>

		<div>
            <input class="btn" type="button"  value="点击导出文件">
			<table class="table table-striped table2excel" id="tableSort">
				<thead>
					<tr>
						<th width= "5%" data-type="num"><?php echo "序号";?></th>
						<th width="15%" data-type="string"><?php echo "学号";?></th>
						<th width="10%" data-type="string"><?php echo "姓名";?></th>
						<th width="25%" data-type="string"><?php echo "年级专业";?></th>
						<th width="15%" data-type="num"><?php echo "QQ";?></th>
						<th width="15%" data-type="num"><?php echo "手机号码";?></th>
						<th width="15%" data-type="date"><?php echo "时间";?></th>
					</tr>
				</thead>
				<tbody>
				<?php $cnt=1;
				foreach($users as $row) {
					echo "<tr>";
					echo "<td>".$cnt++."</td>";
					echo "<td>".$row['user_id']."</td>";
					echo "<td>".$row['username']."</td>";
					echo "<td>".$row['grade']."级".$row['major']."</td>";
					echo "<td>".$row['qq']."</td>";
					echo "<td>".$row['tel']."</td>";
					echo "<td>".$row['time']."</td>";
					echo "</tr>";
				}
				?>
				</tbody>
			</table>
		</div>
	</div>
    <script type="text/javascript">
        $(function() {
            $(".btn").click(function(){
                $(".table2excel").table2excel({
                    // 不被导出的表格行的CSS class类
                    exclude: ".noExl",
                    // 导出的Excel文档的名称
                    name: "ACM协会成员",
                    // Excel文件的名称
                    filename: "ACM协会成员",
                    //文件后缀名
                    fileext: ".xls",
                    //是否排除导出图片
                    exclude_img: false,
                    //是否排除导出超链接
                    exclude_links: false,
                    //是否排除导出输入框中的内容
                    exclude_inputs: false
                });
            });
        });
        ;(function(){
            var tbody = document.querySelector('#tableSort').tBodies[0];
            var th = document.querySelector('#tableSort').tHead.rows[0].cells;
            var td = tbody.rows;
            for(var i = 0;i < th.length;i++){
                th[i].flag = 1;
                th[i].onclick = function(){
                    sort(this.getAttribute('data-type'),this.flag,this.cellIndex);
                    this.flag = -this.flag;
                };
            };
            function sort(str,flag,n){
                var arr = [];
                for(var i = 0;i < td.length;i++){
                    arr.push(td[i]);
                };
                arr.sort(function(a,b){
                    return method(str,a.cells[n].innerHTML,b.cells[n].innerHTML) * flag;
                });
                for(var i = 0;i < arr.length;i++){
                    tbody.appendChild(arr[i]);
                };
            };
            function method(str,a,b){
                switch(str){
                    case 'num':
                        return a-b;
                        break;
                    case 'string':
                        return a.localeCompare(b);
                        break;
                    default:
                        return new Date(a.split('-').join('/')).getTime()-new Date(b.split('-').join('/')).getTime();
                };
            };
        })();
    </script>
</body>
</html>