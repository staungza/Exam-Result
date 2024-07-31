/* Adjust the size of the chart widget to 4:3 aspect ratio */
.filament-widget.StudentAdminChart .filament-chart-widget {
    position: relative;
    width: 100%; /* Ensure widget spans full width */
    padding-bottom: calc(75% - 40px); /* 4:3 aspect ratio (height/width * 100%) */
    overflow: hidden;
    border: 1px solid #ddd; /* Optional: Add border for visual clarity */
}

.filament-widget.StudentAdminChart .filament-chart-widget canvas {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
