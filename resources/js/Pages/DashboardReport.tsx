import React from "react";
import { useState } from "react";
import { router } from "@inertiajs/react";
import { Head } from "@inertiajs/react";
import {
    Button,
    Group,
    Select,
    Stack,
    Text,
    ActionIcon,
    Flex,
} from "@mantine/core";
import { IconSearch, IconDownload } from "@tabler/icons-react";
import { DataTable } from "mantine-datatable";
import { Authenticated } from "@/Modules/Common/Layouts/AuthenticatedLayout/Authenticated";
import { useSearchDataTable } from "@/Modules/Common/Hooks/use-search-datatable";
import { usePaginateDataTable } from "@/Modules/Common/Hooks/use-paginate-datatable";
import useGenerateReport from "@/Modules/Common/Hooks/use-generate-report";
import useModalStore from "@/Modules/Common/Hooks/use-modal-store";
import { PaginationData } from "@/Modules/Common/Types/CommonPageTypes";
import { MetadataResourceData } from "@/Modules/Metadata/Types/MetadataResourceData";
import SelectDashboardMetadataColumnForm from "@/Modules/Dashboard/Components/SelectDashboardMetadataColumnForm";
import { DashboardMetadataResourceData } from "@/Modules/Dashboard/Types/DashboardMetadataResourceData";
import { ItemContentsResourceData } from "@/Modules/Item/Types/ItemContentsResourceData";
import { DatePickerInput } from "@mantine/dates";
import { ItemIcon } from "@/Modules/Common/Components/ItemIcon/ItemIcon";

interface DashboardReportProps {
    documents: PaginationData<ItemContentsResourceData>;
    filters: {
        document_status: string | null;
        start_date: string | null;
        end_date: string | null;
    };
    selectedMetadata: MetadataResourceData[];
    availableMetadata: DashboardMetadataResourceData[];
    existingMetadataIds: number[];
}

export default function DashboardReportPage({
    documents,
    filters,
    selectedMetadata,
    availableMetadata,
    existingMetadataIds,
}: DashboardReportProps) {
    const [documentStatus, setDocumentStatus] = useState<string | null>(filters.document_status);
    const [dateRange, setDateRange] = useState<[Date | null, Date | null]>([
        filters.start_date ? new Date(filters.start_date) : null,
        filters.end_date ? new Date(filters.end_date) : null,
    ]);

    const { search, setSearch, handleSearch } = useSearchDataTable("", `/dashboard/reports`);
    const { page, setPage, handlePageChange } = usePaginateDataTable(documents.current_page);

    const { generateReport } = useGenerateReport();

    const { openModal } = useModalStore();

    const handleFilter = () => {
        const query: any = {};

        if (documentStatus) {
            query.document_status = documentStatus;
        }

        if (dateRange[0] && dateRange[1]) {
            query.start_date = dateRange[0].toISOString().split('T')[0];
            query.end_date = dateRange[1].toISOString().split('T')[0];
        }

        // Navigate with Inertia to apply filters
        router.get("/dashboard/reports", query, { replace: true, preserveState: true });
    };

    const handleGenerateReport = () => {
        const folderItemId = "your-folder-item-id"; // Replace with actual folder ID or dynamically obtain it
        generateReport(folderItemId);
    };

    return (
        <Authenticated>
            <Head title="Dashboard Report" />
            <Stack px={8} gap={24} py={8}>
                <Group>
                    <Text component="h2" size="xl" fw={600} c="gray.8">
                        Dashboard Report
                    </Text>
                </Group>

                <Stack>
                    {/* Filter Options */}
                    <Group justify="space-between">
                        <Flex
                            gap="md"
                            justify="flex-start"
                            align="flex-end"
                            direction="row"
                            wrap="wrap"
                        >
                            <Select
                                placeholder="Select document status"
                                value={documentStatus}
                                onChange={setDocumentStatus}
                                data={[
                                    { value: "reviewal_accepted", label: "Review Accepted" },
                                    { value: "reviewal_rejected", label: "Review Rejected" },
                                    { value: "reviewal_pending", label: "Review Pending" },
                                    { value: "approval_accepted", label: "Approval Accepted" },
                                    { value: "approval_rejected", label: "Approval Rejected" },
                                    { value: "approval_pending", label: "Approval Pending" },
                                ]}
                                style={{ width: 200 }}
                            />

                            <DatePickerInput
                                type="range"
                                placeholder="Select date range"
                                value={dateRange}
                                onChange={setDateRange}
                                style={{ width: 300 }}
                            />

                            <Button onClick={handleFilter} leftSection={<IconSearch size={16} />} color="blue">
                                Apply Filters
                            </Button>
                        </Flex>

                        {/* Generate Report Button */}
                        <Button onClick={handleGenerateReport} leftSection={<IconDownload size={16} />} color="green">
                            Generate Report
                        </Button>
                    </Group>

                    <Group>
                        <Button onClick={() => openModal("selectDashboardMetadataColumns")}>
                            Select Metadata Columns
                        </Button>
                    </Group>

                    {/* Existing SelectMetadataColumnForm */}
                    <SelectDashboardMetadataColumnForm
                        folderId="your-folder-item-id"
                        availableMetadata={availableMetadata}
                        existingMetadataIds={existingMetadataIds}
                    />

                    {/* Documents Table */}
                    <DataTable
                        columns={[
                            {
                                accessor: "name",
                                render: ({ mime, type, name, status, missing_required_metadata }) => (
                                    <Group align="center" gap={12}>
                                        <ItemIcon
                                            mime={mime ?? ""}
                                            isFolder={type === "folder"}
                                            approvalStatus={status}
                                            missingRequiredMetadata={missing_required_metadata}
                                        />
                                        <span>{name}</span>
                                    </Group>
                                ),
                            },
                            { accessor: "updated_at", title: "Last Modified" },
                            // Dynamic columns based on selected metadata
                            ...selectedMetadata.map((meta) => ({
                                accessor: `metadata_${meta.id}`,
                                title: meta.name,
                                render: (record: ItemContentsResourceData) => {
                                    const metaValue = record.metadata?.find((m) => m.id === meta.id);
                                    return metaValue ? metaValue.value : "N/A";
                                },
                            })),
                        ]}
                        records={documents.data}
                        totalRecords={documents.total}
                        recordsPerPage={documents.per_page}
                        page={page}
                        onPageChange={() => { }}
                        highlightOnHover
                        verticalSpacing="lg"
                        horizontalSpacing="xl"
                    />
                </Stack>
            </Stack>
        </Authenticated>
    );
}