import { Button, Flex, Modal, Select, Stack, Text, TextInput } from "@mantine/core";
import React, { FormEventHandler } from "react";
import { useForm } from "@inertiajs/react";
import { notifications } from "@mantine/notifications";
import { Metadata } from "@/types";

interface IProps {
    isOpened: boolean;
    close: () => void;
}

const AddMetadataForm: React.FC<IProps> = ({ isOpened, close }) => {
    const { data, setData, post, processing, errors, reset, clearErrors } = useForm<
        Omit<Metadata, "id">
    >({
        name: "",
        description: "",
        type: "",
    });

    const handleClose = () => {
        close();
        reset();
        clearErrors();
    };

    const addmetadataubmit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route("metadata.store"), {
            onSuccess: () => {
                handleClose();
                notifications.show({
                    message: "New metadata added successfully",
                    color: "green",
                });
            },

            onFinish: () => reset(),
        });
    };

    return (
        <Modal
            opened={isOpened}
            onClose={close}
            title={<Text size="lg">Add Metadata</Text>}
            size={550}
        >
            <form onSubmit={addmetadataubmit}>
                <Stack gap={16}>
                    <TextInput
                        id="name"
                        type="text"
                        name="name"
                        value={data.name}
                        label="Name"
                        onChange={(e) => setData("name", e.target.value)}
                        error={errors.name}
                    />

                    <TextInput
                        id="description"
                        type="text"
                        name="description"
                        value={data.description}
                        label="Description"
                        onChange={(e) => setData("description", e.target.value)}
                        error={errors.description}
                    />

                    <Select
                        label="Type"
                        placeholder="Choose Type"
                        value={data.type}
                        onChange={(_value, option) => setData("type", option.value)}
                        error={errors.type}
                        data={["String", "Boolean", "Datetime"]}
                    />
                </Stack>

                <Flex align="center" justify="end" mt={16}>
                    <Button variant="outline" onClick={handleClose}>
                        Cancel
                    </Button>

                    <Button ml={12} type="submit" loading={processing}>
                        Save
                    </Button>
                </Flex>
            </form>
        </Modal>
    );
};

export default AddMetadataForm;