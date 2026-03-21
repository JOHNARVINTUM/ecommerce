import './bootstrap';

import Alpine from 'alpinejs';

window.ordersOverviewChart = function ordersOverviewChart(orderChartData, statusOrder, statusLabels) {
    return {
        orderChartData,
        statusOrder,
        statusLabels,
        selectedRange: 'all',
        hoveredIndex: null,
        get current() {
            return this.orderChartData[this.selectedRange] ?? this.orderChartData.all;
        },
        get hoveredPoint() {
            if (this.hoveredIndex === null) {
                return null;
            }

            const label = this.current?.labels?.[this.hoveredIndex];
            const value = this.current?.values?.[this.hoveredIndex];

            if (label === undefined || value === undefined) {
                return null;
            }

            return { label, value };
        },
        pointCount() {
            return this.current?.values?.length || 1;
        },
        value(status) {
            return this.current?.status_counts?.[status] ?? 0;
        },
        xPos(index) {
            const count = this.pointCount();
            const width = 560;
            const step = width / count;
            return 50 + (step * index) + (step / 2);
        },
        bandWidth() {
            return 560 / this.pointCount();
        },
        bandStart(index) {
            return 50 + (this.bandWidth() * index);
        },
        yPos(value) {
            const max = this.current?.max_count ?? 1;
            const ratio = max > 0 ? (value / max) : 0;
            return 240 - (ratio * 220);
        },
        linePoints() {
            return (this.current?.values ?? [])
                .map((point, index) => `${this.xPos(index)},${this.yPos(point)}`)
                .join(' ');
        },
        setHover(index) {
            this.hoveredIndex = index;
        },
        clearHover() {
            this.hoveredIndex = null;
        },
        tooltipX() {
            if (this.hoveredIndex === null) {
                return 0;
            }

            return Math.min(Math.max(this.xPos(this.hoveredIndex) - 52, 8), 456);
        },
        tooltipY() {
            if (this.hoveredIndex === null) {
                return 0;
            }

            const point = this.current?.values?.[this.hoveredIndex] ?? 0;

            return Math.max(this.yPos(point) - 56, 18);
        },
        rangeDescription() {
            if (this.selectedRange === 'month') {
                return 'Weekly orders for the current month';
            }

            if (this.selectedRange === '7d') {
                return 'Daily orders for the last 7 days';
            }

            return 'All-time order totals by status';
        },
        xAxisLabel() {
            if (this.selectedRange === 'month') {
                return 'Weeks of the current month';
            }

            if (this.selectedRange === '7d') {
                return 'Days';
            }

            return 'Order status';
        },
        labelGridClass() {
            const count = this.pointCount();

            return {
                'grid gap-2': true,
                'grid-cols-4': count === 4,
                'grid-cols-5': count === 5,
                'grid-cols-7': count === 7,
            };
        },
    };
};

window.Alpine = Alpine;

Alpine.start();
