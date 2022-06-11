<?php
include 'views/header.php';

$page = $_GET['page'];
if ($page < 1 || $page == '' || !is_numeric($page)) $page = 1;

$users = new User();
if (!empty(getGET('keyword'))) {
    $listUsers = $users->search(getGET('keyword'), $page);
    $total = $users->getCountSearch(getGET('keyword'));
} else {
    $listUsers = $users->getUsers($page);
    $total = $users->getCount();
}
?>
<!-- BEGIN: Page Main-->
<div id="main">
    <div class="row">
        <div class="content-wrapper-before gradient-45deg-purple-deep-purple"></div>
        <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
            <!-- Search for small screen-->
            <div class="container">
                <div class="row">
                    <div class="col s10 m6 l6">
                        <h5 class="breadcrumbs-title mt-0 mb-0"><span>Danh sách khách hàng</span></h5>
                        <ol class="breadcrumbs mb-0">
                            <li class="breadcrumb-item"><a href="index.html">Khách hàng</a>
                            </li>
                            <li class="breadcrumb-item active">Danh sách khách hàng</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12">
            <div class="container">
                <div class="section">
                    <div class="row">
                        <div class="col s12">
                            <div id="input-fields" class="card card-tabs">
                                <div class="card-content">
                                    <div class="card-title">
                                        <div class="row">
                                            <div class="col s12 m6 l10">
                                                <h4 class="card-title">Lọc khách hàng</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12">
                                            <p>Tìm kiếm nhanh theo tên, email hoặc số điện thoại.</p>
                                            <br>
                                            <form class="row" method="get" action="">
                                                <div class="col s4">
                                                    <div class="input-field col s12">
                                                        <input placeholder="keyword" id="keyword" type="text" class="validate" name="keyword" />
                                                        <label for="keyword">Thông tin</label>
                                                    </div>
                                                </div>
                                                <div class="col s4">
                                                    <div class="col s12">
                                                        <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Tìm kiếm <i class="material-icons right">send</i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-overlay"></div>
        </div>
        <div class="col s12">
            <div class="container">
                <div class="section">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div id="highlight-table" class="card card card-default scrollspy">
                                <div class="card-content">
                                    <!-- <h4 class="card-title">Danh sách</h4> -->
                                    <!-- <p class="mb-2">Add <code class=" language-markup">class="Highlight"</code> to the table tag for a highlight table</p> -->
                                    <div class="row">
                                        <div class="col s12">
                                        </div>
                                        <div class="col s12">
                                            <table class="highlight">
                                                <thead>
                                                    <tr>
                                                        <th>ID khách hàng</th>
                                                        <th>Họ tên</th>
                                                        <th>Email</th>
                                                        <th>Số điện thoại</th>
                                                        <th>Hành động</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($listUsers as $k => $v) {
                                                        echo '<tr>
																<td>U-' . $v['user_id'] . '</td>
																<td>' . $v['user_fullname'] . '</td>
																<td>' . $v['user_email'] . '</td>
																<td>' . $v['user_phone_number'] . '</td>
																<td>
																	<div class="invoice-action">
																		<a href="user.html?user_id=' . $v['user_id'] . '" class="invoice-action-view mr-4" title="Thông tin khách hàng"><i class="material-icons">remove_red_eye</i></a>
																	</div>
																</td>
															</tr>';
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Pagination -->
                            <div class="col s12 center">
                                <ul class="pagination">
                                    <?php
                                    // $total = $invoices->getCount();
                                    $limit = (($page - 1) * DATA_PER_PAGE) . ',' . DATA_PER_PAGE;
                                    $end_page =  ceil($total / DATA_PER_PAGE);
                                    $page_item = [];
                                    for ($i = 1; $i <= $end_page; $i++) if (abs($page - $i) <= 3 || $i == 1 || $i == $end_page) {
                                        $page_item[] = $i;
                                        echo '<li class="' . ($page == $i ? 'active' : 'waves-effect') . '"><a href="?page=' . $i . '">' . $i . '</a></li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-overlay"></div>
        </div>
    </div>
</div>
<!-- END: Page Main-->
<?php
include 'views/footer.php';
?>