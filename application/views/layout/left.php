<nav>
    <ul>
        <?php if(substr_count($this->input->server("REQUEST_URI"),"/member") > 0): ?>
        <li class="left-li active">
            <div class="left-item">회원</div>
            <div class="left-icon">-</div>
            <div class="sub-menu" style="display:block">
                <?php if(substr_count($this->input->server("REQUEST_URI"),"/member/lists") > 0): ?>
                <a href="/member/lists" class="active"><p class="active">회원 관리</p></a>
                <?php else: ?>
                <a href="/member/lists"><p >회원 관리</p></a>
                <?php endif; ?>
                <?php if(substr_count($this->input->server("REQUEST_URI"),"/member/setting") > 0): ?>
                <a href="/member/setting" class="active"><p class="active">분류 및 END User 관리</p></a>
                <?php else: ?>
                <a href="/member/setting"><p >분류 및 END User 관리</p></a>
                <?php endif; ?>
            </div>
        </li>
        <?php else: ?>
        <li class="left-li">
            <div class="left-item">회원</div>
            <div class="left-icon">+</div>
            <div class="sub-menu ">
                <a href="/member/lists"><p >회원 관리</p></a>
                <a href="/member/setting"><p >분류 및 END User 관리</p></a>
            </div>
        </li>
        <?php endif; ?>
        <?php if(substr_count($this->input->server("REQUEST_URI"),"/service") > 0): ?>
        <li class="left-li active">
            <div class="left-item">서비스</div>
            <div class="left-icon">-</div>
            <div class="sub-menu" style="display:block">
                <?php if(substr_count($this->input->server("REQUEST_URI"),"/service/estimate") > 0): ?>
                <a href="/service/estimate" class="active"><p class="active">견적 관리</p></a>
                <?php else: ?>
                <a href="/service/estimate"><p >견적 관리</p></a>
                <?php endif; ?>
                <?php if(substr_count($this->input->server("REQUEST_URI"),"/service/register") > 0): ?>
                <a href="/service/register" class="active"><p >서비스 등록</p></a>
                <?php else: ?>
                <a href="/service/register"><p >서비스 등록</p></a>
                <?php endif; ?>
                <?php if(substr_count($this->input->server("REQUEST_URI"),"/service/list") > 0): ?>
                <a href="/service/list" class="active"><p >서비스 관리</p></a>
                <?php else: ?>
                <a href="/service/list"><p >서비스 관리</p></a>
                <?php endif; ?>
            </div>
        </li>
        <?php else: ?>
        <li class="left-li">
            <div class="left-item">서비스</div>
            <div class="left-icon">+</div>
            <div class="sub-menu">
                <a href="/service/estimate"><p >견적 관리</p></a>
                <a href="/service/register"><p >서비스 등록</p></a>
                <a href="/service/list"><p ">서비스 관리</p></a>
            </div>
        </li>
        <?php endif; ?>
        <?php if(substr_count($this->input->server("REQUEST_URI"),"/product") > 0): ?>
        <li class="left-li active">
            <div class="left-item">상품</div>
            <div class="left-icon">-</div>
            <div class="sub-menu" style="display:block">
                <?php if(substr_count($this->input->server("REQUEST_URI"),"/product/register") > 0): ?>
                <a href="/product/register" class="active"><p class="active">상품 등록</p></a>
                <?php else: ?>
                <a href="/product/register"><p>상품 등록</p></a>
                <?php endif; ?>
                <?php if(substr_count($this->input->server("REQUEST_URI"),"/product/clients") > 0): ?>
                <a href="/product/clients" class="active"><p class="active">매입처 등록</p></a>
                <?php else: ?>
                <a href="/product/clients"><p>매입처 등록</p></a>
                <?php endif; ?>

            </div>
        </li>
        <?php else: ?>
        <li class="left-li">
            <div class="left-item">상품</div>
            <div class="left-icon">+</div>
            <div class="sub-menu">
                <a href="/product/register"><p >상품 등록</p></a>
                <a href="/product/clients"><p>매입처 등록</p></a>

            </div>
        </li>
        <?php endif; ?>

        <li class="left-li">
            <div class="left-item">구매 및 재고</div>
            <div class="left-icon">+</div>
            <div class="sub-menu">
                <a href="#"><p >구매 기안</p></a>
                <a href="#"><p>재고 관리</p></a>

            </div>
        </li>
        <li class="left-li">
            <div class="left-item">요금</div>
            <div class="left-icon">+</div>
        </li>
        <li class="left-li">
            <div class="left-item">사내 관리</div>
            <div class="left-icon">+</div>
        </li>
    </ul>
</nav>