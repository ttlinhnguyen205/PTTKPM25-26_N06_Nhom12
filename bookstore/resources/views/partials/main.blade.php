<div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Welcome Readora</h3>
                  <h6 class="font-weight-normal mb-0">All systems are running smoothly!</span></h6>

                </div>
                <div class="col-12 col-xl-4">
                 <div class="justify-content-end d-flex">
                  <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                    <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                     <i class="mdi mdi-calendar"></i> Today (10 Jan 2025)
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                      <a class="dropdown-item" href="#">January - March</a>
                      <a class="dropdown-item" href="#">March - June</a>
                      <a class="dropdown-item" href="#">June - August</a>
                      <a class="dropdown-item" href="#">August - November</a>
                    </div>
                  </div>
                 </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card tale-bg">
                <div class="card-people mt-auto">
                  <img src="{{asset('images/dashboard/people.svg')}}" alt="people">
                  <div class="weather-info">
                    <div class="d-flex">
                      <div>
                        <h2 class="mb-0 font-weight-normal"><i class="icon-sun mr-2"></i>31<sup>C</sup></h2>
                      </div>
                      <div class="ml-2">
                        <h4 class="location font-weight-normal">Ha Noi</h4>
                        <h6 class="font-weight-normal">Viet Nam</h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin transparent">
              <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-tale">
                    <div class="card-body">
                      <p class="mb-4">Total Products</p>
                      <p class="fs-30 mb-2">{{ $totalProducts }}</p>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-dark-blue">
                    <div class="card-body">
                      <p class="mb-4">Total Categories</p>
                      <p class="fs-30 mb-2">{{ $totalCategories }}</p>
                    </div>
                  </div>
                </div>

              </div>
              <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                  <div class="card card-light-blue">
                    <div class="card-body">
                      <p class="mb-4">Total Orders</p>
                      <p class="fs-30 mb-2">{{ $totalOrders }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 stretch-card transparent">
                  <div class="card card-light-danger">
                    <div class="card-body">
                      <p class="mb-4">Tổng số khách hàng</p>
                      <p class="fs-30 mb-2">{{ $totalClients }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            {{-- ===== CỘT TRÁI: ORDER DETAILS ===== --}}
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Order Details</p>
                  <p class="font-weight-500 mb-3">Danh sách 5 đơn hàng gần nhất</p>

                  <div class="table-responsive">
                    <table class="table table-striped table-borderless align-middle">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Customer</th>
                          <th>Total Money</th>
                          <th>Status</th>
                          <th>Order Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($recentOrders as $order)
                          <tr>
                            <td>
                              <a href="{{ route('admin.orders.show', $order->id) }}" class="text-primary fw-semibold">
                                #{{ $order->id }}
                              </a>
                            </td>
                            <td>{{ $order->customer->name ?? 'N/A' }}</td>
                            <td>{{ number_format($order->total_money, 0, ',', '.') }} ₫</td>
                            <td>
                              @php
                                $statusClass = match($order->status) {
                                  'pending'   => 'badge bg-secondary',
                                  'confirmed' => 'badge bg-info',
                                  'shipping'  => 'badge bg-primary',
                                  'completed' => 'badge bg-success',
                                  'cancelled' => 'badge bg-danger',
                                  default     => 'badge bg-light text-dark',
                                };
                              @endphp
                              <span class="{{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                          </tr>
                        @empty
                          <tr>
                            <td colspan="5" class="text-center text-muted py-3">Chưa có đơn hàng nào</td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>

                  {{-- Tổng cộng --}}
                  <div class="text-end mt-3">
                    <strong>Tổng doanh thu 5 đơn gần nhất:</strong>
                    <span class="text-primary fw-bold">
                      {{ number_format($recentOrdersTotal, 0, ',', '.') }} ₫
                    </span>
                  </div>
                </div>
              </div>
            </div>

            {{-- ===== CỘT PHẢI: SALES REPORT ===== --}}
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <p class="card-title">Sales Report</p>
                  </div>

                  <p class="font-weight-500">Biểu đồ doanh thu theo tháng trong {{ $year }}.</p>

                  <div class="text-center mb-3">
                    <h4 class="font-weight-bold text-success">
                      Tổng doanh thu: {{ number_format($totalYear, 0, ',', '.') }} ₫
                    </h4>
                  </div>
                  {{-- Bảng doanh thu theo tháng từ CSDL --}}
                  <div class="table-responsive mt-3">
                    <table class="table table-bordered table-striped">
                      <thead class="table-light">
                        <tr>
                          <th>Tháng</th>
                          <th>Doanh thu (₫)</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($revenues as $r)
                          <tr>
                            <td>Tháng {{ $r->month }}</td>
                            <td>{{ number_format($r->total, 0, ',', '.') }} ₫</td>
                          </tr>
                        @empty
                          <tr>
                            <td colspan="2" class="text-center text-muted py-3">Chưa có doanh thu trong năm {{ $year }}</td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card position-relative">
              </div>
            </div>
          </div>
          <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <p class="card-title mb-0">Top Products (Tháng {{ now()->month }})</p>
                <p class="text-muted small mb-3">5 sản phẩm bán chạy nhất trong tháng hiện tại</p>
                <div class="table-responsive">
                  <table class="table table-striped table-borderless">
                    <thead>
                      <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Đã bán</th>
                        <th>Trạng thái</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($topProducts as $product)
                        <tr>
                          <td>{{ $product->name }}</td>
                          <td>{{ number_format($product->price, 0, ',', '.') }} đ</td>
                          <td>{{ $product->total_sold }}</td>
                          <td>
                            <div class="badge {{ $product->total_sold > 0 ? 'badge-success' : 'badge-secondary' }}">
                              {{ $product->total_sold > 0 ? 'Available' : 'Out of stock' }}
                            </div>
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="4" class="text-center text-muted">Chưa có dữ liệu bán hàng trong tháng này</td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4 stretch-card grid-margin">
              <div class="card">
                <div class="card-body">
                  <p class="card-title mb-0">Projects</p>
                  <div class="table-responsive">
                    <table class="table table-borderless">
                      <thead>
                        <tr>
                          <th class="pl-0  pb-2 border-bottom">Places</th>
                          <th class="border-bottom pb-2">Orders</th>
                          <th class="border-bottom pb-2">Users</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="pl-0">Kentucky</td>
                          <td><p class="mb-0"><span class="font-weight-bold mr-2">65</span>(2.15%)</p></td>
                          <td class="text-muted">65</td>
                        </tr>
                        <tr>
                          <td class="pl-0">Ohio</td>
                          <td><p class="mb-0"><span class="font-weight-bold mr-2">54</span>(3.25%)</p></td>
                          <td class="text-muted">51</td>
                        </tr>
                        <tr>
                          <td class="pl-0">Nevada</td>
                          <td><p class="mb-0"><span class="font-weight-bold mr-2">22</span>(2.22%)</p></td>
                          <td class="text-muted">32</td>
                        </tr>
                        <tr>
                          <td class="pl-0">North Carolina</td>
                          <td><p class="mb-0"><span class="font-weight-bold mr-2">46</span>(3.27%)</p></td>
                          <td class="text-muted">15</td>
                        </tr>
                        <tr>
                          <td class="pl-0">Montana</td>
                          <td><p class="mb-0"><span class="font-weight-bold mr-2">17</span>(1.25%)</p></td>
                          <td class="text-muted">25</td>
                        </tr>
                        <tr>
                          <td class="pl-0">Nevada</td>
                          <td><p class="mb-0"><span class="font-weight-bold mr-2">52</span>(3.11%)</p></td>
                          <td class="text-muted">71</td>
                        </tr>
                        <tr>
                          <td class="pl-0 pb-0">Louisiana</td>
                          <td class="pb-0"><p class="mb-0"><span class="font-weight-bold mr-2">25</span>(1.32%)</p></td>
                          <td class="pb-0">14</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
              <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <p class="card-title">Charts</p>
                      <div class="charts-data">
                        <div class="mt-3">
                          <p class="mb-0">Data 1</p>
                          <div class="d-flex justify-content-between align-items-center">
                            <div class="progress progress-md flex-grow-1 mr-4">
                              <div class="progress-bar bg-inf0" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">5k</p>
                          </div>
                        </div>
                        <div class="mt-3">
                          <p class="mb-0">Data 2</p>
                          <div class="d-flex justify-content-between align-items-center">
                            <div class="progress progress-md flex-grow-1 mr-4">
                              <div class="progress-bar bg-info" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">1k</p>
                          </div>
                        </div>
                        <div class="mt-3">
                          <p class="mb-0">Data 3</p>
                          <div class="d-flex justify-content-between align-items-center">
                            <div class="progress progress-md flex-grow-1 mr-4">
                              <div class="progress-bar bg-info" role="progressbar" style="width: 48%" aria-valuenow="48" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">992</p>
                          </div>
                        </div>
                        <div class="mt-3">
                          <p class="mb-0">Data 4</p>
                          <div class="d-flex justify-content-between align-items-center">
                            <div class="progress progress-md flex-grow-1 mr-4">
                              <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">687</p>
                          </div>
                        </div>
                      </div>  
                    </div>
                  </div>
                </div>
                <div class="col-md-12 stretch-card grid-margin grid-margin-md-0">
                  <div class="card data-icon-card-primary">
                    <div class="card-body">
                      <p class="card-title text-white">Number of Meetings</p>                      
                      <div class="row">
                        <div class="col-8 text-white">
                          <h3>34040</h3>
                          <p class="text-white font-weight-500 mb-0">The total number of sessions within the date range.It is calculated as the sum . </p>
                        </div>
                        <div class="col-4 background-icon">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Notifications</p>
                  <ul class="icon-data-list">
                    <li>
                      <div class="d-flex">
                        <img src="{{asset('images/faces/face1.jpg')}}" alt="user">
                        <div>
                          <p class="text-info mb-1">Isabella Becker</p>
                          <p class="mb-0">Sales dashboard have been created</p>
                          <small>9:30 am</small>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="d-flex">
                        <img src="{{asset('images/faces/face2.jpg')}}" alt="user">
                        <div>
                          <p class="text-info mb-1">Adam Warren</p>
                          <p class="mb-0">You have done a great job #TW111</p>
                          <small>10:30 am</small>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="d-flex">
                      <img src="{{asset('images/faces/face3.jpg')}}" alt="user">
                     <div>
                      <p class="text-info mb-1">Leonard Thornton</p>
                      <p class="mb-0">Sales dashboard have been created</p>
                      <small>11:30 am</small>
                     </div>
                      </div>
                    </li>
                    <li>
                      <div class="d-flex">
                        <img src="{{asset('images/faces/face4.jpg')}}" alt="user">
                        <div>
                          <p class="text-info mb-1">George Morrison</p>
                          <p class="mb-0">Sales dashboard have been created</p>
                          <small>8:50 am</small>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="d-flex">
                        <img src="{{asset('images/faces/face5.jpg')}}" alt="user">
                        <div>
                        <p class="text-info mb-1">Ryan Cortez</p>
                        <p class="mb-0">Herbs are fun and easy to grow.</p>
                        <small>9:00 am</small>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="row">

        </div>